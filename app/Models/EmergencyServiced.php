<?php

namespace App\Models;

use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\EmergencyServiced
 *
 * @SWG\Definition (
 *      definition="EmergencyServiced",
 *      required={"name", "address", "price_per_day", "type", "contact", "available"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ), @SWG\Property(
 *          property="contact",
 *          description="contact",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="address",
 *          description="address",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="price_per_day",
 *          description="price_per_day",
 *          type="number",
 *          format="number"
 *      ),
 *      @SWG\Property(
 *          property="type",
 *          description="type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="available",
 *          description="available",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
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
 * @property string $address
 * @property string|null $contact
 * @property float $price_per_day
 * @property string $type
 * @property int $available
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User $doctor
 * @property-read Collection|EmergencyServiced[] $emergency
 * @property-read int|null $emergency_count
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyServiced newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyServiced newQuery()
 * @method static Builder|EmergencyServiced onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyServiced query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyServiced whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyServiced whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyServiced whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyServiced whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyServiced whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyServiced whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyServiced whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyServiced wherePricePerDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyServiced whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyServiced whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyServiced whereUserId($value)
 * @method static Builder|EmergencyServiced withTrashed()
 * @method static Builder|EmergencyServiced withoutTrashed()
 * @mixin Eloquent
 */
class EmergencyServiced extends Model
{
    use SoftDeletes;

    public $table = 'emergency_serviceds';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'contact',
        'address',
        'price_per_day',
        'type',
        'available',
        'doctor_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'contact' => 'string',
        'address' => 'string',
        'price_per_day' => 'double',
        'type' => 'string',
        'available' => 'integer',
        'user_id' => 'integer',
        'doctor_id' => 'integer'
    ];


    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * @return HasMany
     */
    public function emergency()
    {
        return $this->hasMany(EmergencyServiced::class, 'emergency_id');
    }
}
