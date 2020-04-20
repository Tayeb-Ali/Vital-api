<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * Class MedicalField
 *
 * @package App\Models
 * @version February 19, 2020, 4:54 pm UTC
 * @property string name
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalField newQuery()
 * @method static Builder|MedicalField onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalField query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalField whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalField whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalField whereUpdatedAt($value)
 * @method static Builder|MedicalField withTrashed()
 * @method static Builder|MedicalField withoutTrashed()
 * @mixin Eloquent
 */
class MedicalField extends Model
{
    use SoftDeletes;

    public $table = 'medical_fields';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    /**
     * @return HasMany
     */
    public function medical()
    {
        return $this->hasMany(MedicalSpecialty::class, 'medical_id');
    }

}
