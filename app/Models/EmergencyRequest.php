<?php

namespace App\Models;

use App\Models\EmergencyServiced;
use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\EmergencyRequest
 *
 * @SWG\Definition (
 *      definition="EmergencyRequest",
 *      required={"reports", "reports_file", "doctor_id", "emergency_id"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="reports",
 *          description="reports",
 *          type="string"
 *      ), @SWG\Property(
 *          property="reports_file",
 *          description="report_file uploade",
 *          type="string"
 *      )
 *      @SWG\Property(
 *          property="doctor_id",
 *          description="dotor request servers",
 *          type="integer",
 *          format="int32"
 *      ),    @SWG\Property(
 *          property="emergency_id",
 *          description="man emergency request",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 * @property int $id
 * @property string $reports
 * @property string|null $reports_file
 * @property int $doctor_id
 * @property int $emergency_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $doctor
 * @property-read \App\Models\EmergencyServiced $emergency
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyRequest newQuery()
 * @method static Builder|EmergencyRequest onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyRequest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyRequest whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyRequest whereEmergencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyRequest whereReports($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyRequest whereReportsFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyRequest whereUpdatedAt($value)
 * @method static Builder|EmergencyRequest withTrashed()
 * @method static Builder|EmergencyRequest withoutTrashed()
 * @mixin Eloquent
 */
class EmergencyRequest extends Model
{
    use SoftDeletes;

    public $table = 'emergency_requests';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'reports',
        'reports_file',
        'doctor_id',
        'emergency_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'reports' => 'string',
        'reports_file' => 'string',
        'doctor_id' => 'integer',
        'emergency_id' => 'integer'
    ];


    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function emergency()
    {
        return $this->belongsTo(EmergencyServiced::class, 'emergency_id');
    }

}
