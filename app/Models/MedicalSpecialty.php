<?php

namespace App\Models;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\MedicalSpecialty
 *
 * @property int $id
 * @property string $name
 * @property int $medical_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read MedicalField $medical
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalSpecialty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalSpecialty newQuery()
 * @method static Builder|MedicalSpecialty onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalSpecialty query()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalSpecialty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalSpecialty whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalSpecialty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalSpecialty whereMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalSpecialty whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalSpecialty whereUpdatedAt($value)
 * @method static Builder|MedicalSpecialty withTrashed()
 * @method static Builder|MedicalSpecialty withoutTrashed()
 * @mixin Eloquent
 */
class MedicalSpecialty extends Model
{
    use SoftDeletes;

    public $table = 'medical_specialties';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'medical_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'medical_id' => 'integer'
    ];



    public function medical()
    {
        return $this->belongsTo(MedicalField::class, 'medical_id');
    }


}
