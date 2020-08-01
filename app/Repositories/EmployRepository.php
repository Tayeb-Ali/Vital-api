<?php

namespace App\Repositories;

use App\Models\Employ;
use App\Models\FileSave;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class EmployRepository
 * @package App\Repositories
 * @version February 19, 2020, 4:55 pm UTC
 */
class EmployRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'graduation_date',
        'birth_of_date',
        'medical_registration_number',
        'registration_date',
        'address',
        'years_of_experience',
        'cv',
        'user_id',
        'medical_fields_id'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Employ::class;
    }


    /**
     * Create model record
     *
     * @param Request $request
     * @return Model
     */
    public function createApi($request)
    {
        $input = $request->all();
        $user = Auth::user();
        if ($user) {
            $model = $this->model->newInstance($input);
            $model->user_id = $user->id;
            $model->save();
            $user->status = env('STATUS_MEDICAL');
            $user->save();
            $wallet = new Wallet();
            $wallet->createWallet();
            $this->saveFile($request, $user->id, $model->id);
            return $model;

        }
        return $user;
    }

    public function saveFile($request, $userId, $employId)
    {

//        $random = Str::random(10);
        if ($request->hasfile('cv')) {
            $image = $request->file('cv');
            $name = $userId . '_cv.' . $request->cv->extension();
            $image->move(base_path() . '/public/cv/', $name);
            $name = url("cv/$name");
            $save = new FileSave();
            $save->name = $request->cv->getClientOriginalName();
            $save->extension = $request->cv->extension();
            $save->employ_id = $employId;
            $save->url = $name;
           return $save->save();
            return $name;
        }
        return null;
    }

}
