<?php

namespace App\Models;

use App\FcmHelper;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * Class AcceptRequestSpecialists
 *
 * @package App\Models
 * @version February 19, 2020, 5:27 pm UTC
 * @property User
 * @property RequestSpecialists request
 * @property string note
 * @property string recommendation
 * @property number rating
 * @property integer doctor_id
 * @property integer request_id
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User $doctor
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|AcceptRequestSpecialists newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AcceptRequestSpecialists newQuery()
 * @method static Builder|AcceptRequestSpecialists onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AcceptRequestSpecialists query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|AcceptRequestSpecialists whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcceptRequestSpecialists whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcceptRequestSpecialists whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcceptRequestSpecialists whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcceptRequestSpecialists whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcceptRequestSpecialists whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcceptRequestSpecialists whereRecommendation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcceptRequestSpecialists whereRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcceptRequestSpecialists whereUpdatedAt($value)
 * @method static Builder|AcceptRequestSpecialists withTrashed()
 * @method static Builder|AcceptRequestSpecialists withoutTrashed()
 */
class AcceptRequestSpecialists extends Model
{
    use SoftDeletes;

    public $table = 'accept_request_specialists';
//    public $with = ['doctor', 'request'];


    protected $dates = ['deleted_at'];


    public $fillable = [
        'note',
        'recommendation',
        'rating',
        'doctor_id',
        'request_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'note' => 'string',
        'recommendation' => 'string',
        'doctor_id' => 'integer',
        'request_id' => 'integer'
    ];

    /**
     * @return BelongsTo
     **/
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }

    /**
     * @return BelongsTo
     **/
    public function request()
    {
        return $this->belongsTo(RequestSpecialists::class, 'request_id', 'id');
    }


    public function acceptRequest($request, $user)
    {
        $fcm = new FcmHelper();
        $accept = new AcceptRequestSpecialists($request->all());
        $accept->user_id = $user->id;
        $accept = $accept->save();
        $requestUpdate = RequestSpecialists::whereId($request->request_id)->update(['status' => 3]);
        $fcmData = [
            'title' => "Request update",
            "message" => "You have received new message from" . $user->name,
            'fcm_registration_id' => $user->fcm_registration_id];
        $fcm = $fcm->send_android_fcm(fcm_registration_id, '', '', '');
        $data = [$accept, $requestUpdate, $fcmData, $fcm];

        return $data;


    }


    /*
     * @param status
     * have value from 1to 6
     * where 1 = new request by admin
     * and 2 accept by user
     * and 3 accept user by admin
     * and 4 cancel request by admin
     * and 5 cancel request by user
     * and 6 is accept request that is don
     * */


    public function acceptRequestByUser($requestId, $doctor_id)
    {
        $requestSpecialistData = RequestSpecialists::where('id', $requestId)
            ->where('status', env("STATUS_NEW"))->first();

        if (!empty($requestSpecialistData)) {
            $acceptRequest = new AcceptRequestSpecialists();
            $acceptRequest->doctor_id = $doctor_id;
            $acceptRequest->request_id = $requestId;
            $acceptRequest->save();
            $requestSpecialistData->status = env("STATUS_MEDICAL");
            $requestSpecialistData->doctor_id = $doctor_id;
            $requestSpecialistData->save();
            $this->fcm_send([$requestSpecialistData->user
                ->fcm_registration_id],
                "new message",
                "Your Request has accept By a Doctor: " . $requestSpecialistData->doctor->name, $requestSpecialistData);
            return ['accept' => true, 'request' => true, 'acceptRequest' => $requestSpecialistData];
        } else {
            return ['accept' => false, 'request' => false];
        }
    }

    /**
     * @param $requestId
     * @param $userId
     * @return array
     */
    public function acceptRequestByAdmin($requestId, $userId)
    {

        $resultData = RequestSpecialists::whereId($requestId)
            ->whereStatus(env("STATUS_MEDICAL"))
            ->with('user')
            ->first();
        $result = RequestSpecialists::whereId($requestId)
            ->where('user_id', $userId)
            ->whereStatus(env("STATUS_MEDICAL"))
            ->update(['status' => env("STATUS_ACCEPT_ADMIN")]);
        if ($result == 1) {
            $wallet = Wallet::where('user_id', $resultData->user->id)->first();
            $wallet->balance = $wallet->balance - env('REQUEST_POINT');
            $this->fcm_send([$resultData->user->fcm_registration_id], "new message",
                "The admin:" . $resultData->user->name . " approved your request. ",
                $resultData);
            return ['accept' => true, 'request' => true];
        } else {
            return ['accept' => false, 'request' => false, 'message' => $result];
        }

    }

    /**
     * @param $requestId
     * @return AcceptRequestSpecialists|array|bool|Builder|mixed|null
     * @throws Exception
     */
    public function cancelRequestByAdmin($requestId)
    {
        $acceptRequest = AcceptRequestSpecialists::where('request_id', $requestId)->first();
        $acceptRequest2 = AcceptRequestSpecialists::where('request_id', $requestId)->delete();
        $requestData = RequestSpecialists::with('doctor')->find($requestId);
        $requestData->status = env("STATUS_CANCEL_ADMIN");
        $this->fcm_send([$requestData->doctor->fcm_registration_id],
            "You have received new message ",
            'your last Request is Cancel by admin',
            $acceptRequest);
        $requestData->save();
        if ($acceptRequest2) {
            return ['accept' => true, 'request' => true, 'message' => 'request cancel successful'];
        } else {
            return ['accept' => false, 'request' => false, 'message' => 'request cancel failed'];
        }

    }

    /**
     * @param $requestId
     * @return AcceptRequestSpecialists|array|bool|Builder|mixed|null
     * @throws Exception
     */
    public function cancelRequestByAdminToUser($requestId)
    {
        $acceptRequest = AcceptRequestSpecialists::where('request_id', $requestId)->first();
        $acceptRequest2 = AcceptRequestSpecialists::where('request_id', $requestId)->delete();

        if ($acceptRequest2) {
            $requestData = RequestSpecialists::with('doctor')->find($requestId);
            $requestData->status = env("STATUS_NEW");
            $this->fcm_send([$requestData->doctor->fcm_registration_id],
                "You have received new message ",
                'your last Request is Cancel by admin',
                $acceptRequest);
            $requestData->doctor_id = null;
            $requestData->save();

            return ['accept' => true, 'request' => true, 'message' => 'request cancel successful'];

        } else {
            return ['accept' => false, 'request' => false, 'message' => 'request cancel failed'];
        }

    }

    /**
     * @param $requestId
     * @return array
     * @throws Exception
     * @throws Exception
     */
    public function cancelRequestByUser($requestId)
    {
        $acceptRequest = AcceptRequestSpecialists::whereRequestId($requestId);
        $acceptRequest->delete();
        if ($acceptRequest) {
            $resultData = RequestSpecialists::with('user')->find($requestId);
            $resultData->status = env("STATUS_NEW");
            $resultData->doctor_id = null;
            $resultData->doctor;
            $this->fcm_send([$resultData->user->fcm_registration_id],
                "You have received new message ",
                'your last Request is Cancel by user',
                $resultData);
            $resultData->save();

            return ['accept' => true, 'request' => true];

        } else {
            return ['accept' => false, 'request' => false];
        }

    }

    public function acceptRequestAndDone($requestId, $request)
    {
        $acceptRequest = AcceptRequestSpecialists::whereRequestId($requestId)
            ->update([
                'note' => $request->note,
                'recommendation' => $request->recommendation,
                'rating' => $request->rating
            ]);
        if ($acceptRequest) {
            $requestSpecialist = RequestSpecialists::whereId($requestId)
                ->where('status', env("STATUS_ACCEPT_ADMIN"))
                ->first();
            $requestSpecialist->status = 6;
            $requestSpecialist->save();
            $this->fcm_send([$requestSpecialist->user->fcm_registration_id], "Thanks you from, Vital",
                $requestSpecialist->user->name . " confirmed the end of the shift.",
                $requestSpecialist);
            return ['accept' => true, 'request' => true, 'data' => $requestSpecialist];

        } else {
            return ['accept' => false, 'request' => false];
        }

    }

    public function users_notfication($medical_id, $requestId)
    {
        $medical = MedicalSpecialty::where('id', $medical_id)->first('name');
        $message = 'New Request';
        $title = "$medical->name required";
        $result = new FcmHelper();
        return $result->send_fcm_topic_requests('doctor', $title, $message, $requestId);
    }

    private function fcm_send($fcm_registration_id, $title, $message, $resultData = null)
    {
        $result = new FcmHelper();
        return $result->send_android_fcm($fcm_registration_id, $title, $message, $resultData, 1);
    }

}

