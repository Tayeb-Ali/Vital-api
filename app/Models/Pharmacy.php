<?php

namespace App\Models;

use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\Pharmacy
 *
 * @SWG\Definition (
 *      definition="Pharmacy",
 *      required={"name", "address", "dose", "type"},
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="address",
 *          description="address",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="company",
 *          description="company",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="type",
 *          description="type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="pharmacy_id",
 *          description="pharmacy_id",
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
 * @property string $name
 * @property string|null $address
 * @property int $dose
 * @property bool $company
 * @property string $type
 * @property float|null $price
 * @property bool|null $available
 * @property int $user_id
 * @property int|null $pharmacy_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User|null $pharmacy
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy newQuery()
 * @method static Builder|Pharmacy onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy whereDose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy wherePharmacyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy whereUserId($value)
 * @method static Builder|Pharmacy withTrashed()
 * @method static Builder|Pharmacy withoutTrashed()
 * @mixin Eloquent
 */
class Pharmacy extends Model
{
    use SoftDeletes;

    public $table = 'pharmacies';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'address',
        'dose',
        'company',
        'type',
        'user_id',
        'available',
        'price',
        'pharmacy_id'
    ];


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'address' => 'string',
        'company' => 'boolean',
        'type' => 'string',
        'available' => 'boolean',
        'price' => 'float',
        'user_id' => 'integer',
        'pharmacy_id' => 'integer'
    ];


    /**
     * @return BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     **/
    public function pharmacy()
    {
        return $this->belongsTo(User::class, 'pharmacy_id', 'id');
    }
}
