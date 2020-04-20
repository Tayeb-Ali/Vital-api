<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * Class Employ
 *
 * @package App\Models
 * @version February 19, 2020, 4:55 pm UTC
 * @property User employ
 * @property MedicalField medicalField
 * @property string graduation_date
 * @property string birth_of_date
 * @property string medical_registration_number
 * @property string registration_date
 * @property string address
 * @property integer years_of_experience
 * @property string cv
 * @property integer user_id
 * @property integer medical_fields_id
 * @property int $id
 * @property int $medical_field_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User $doctor
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|Employ newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employ newQuery()
 * @method static Builder|Employ onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employ query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Employ whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employ whereBirthOfDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employ whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employ whereCv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employ whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employ whereGraduationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employ whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employ whereMedicalFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employ whereMedicalRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employ whereRegistrationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employ whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employ whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employ whereYearsOfExperience($value)
 * @method static Builder|Employ withTrashed()
 * @method static Builder|Employ withoutTrashed()
 */
class Employ extends Model
{
    use SoftDeletes;

    public $table = 'employs';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'graduation_date',
        'birth_of_date',
        'medical_registration_number',
        'registration_date',
        'address',
        'years_of_experience',
        'cv',
        'medical_field_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'graduation_date' => 'date',
        'birth_of_date' => 'date',
        'medical_registration_number' => 'string',
        'registration_date' => 'date',
        'address' => 'string',
        'years_of_experience' => 'integer',
        'cv' => 'string',
        'user_id' => 'integer',
        'medical_field_id' => 'integer'
    ];

    /**
     * @param $value
     * @throws \Exception
     */
    public function setDateAttribute($value)
    {
        $this->attributes['graduation_date'] = (new Carbon($value))->format('yyyy-MM-dd');
        $this->attributes['birth_of_date'] = (new Carbon($value))->format('yyyy-MM-dd');
        $this->attributes['registration_date'] = (new Carbon($value))->format('yyyy-MM-dd');
    }

    /**
     * @return BelongsTo
     **/
    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     **/
    public function specialty()
    {
        return $this->belongsTo(MedicalSpecialty::class, 'medical_field_id', 'id');
    }
}
