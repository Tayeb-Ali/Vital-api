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
 * App\Models\Ambulance
 *
 * @SWG\Definition (
 *      definition="Ambulance",
 *      required={"title", "longitude", "latitude"},
 *      @SWG\Property(
 *          property="title",
 *          description="title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="address",
 *          description="address",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="longitude",
 *          description="longitude",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="latitude",
 *          description="latitude",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="integer",
 *          format="int32"
 *      ),  @SWG\Property(
 *          property="status",
 *          description="status",
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
 * @property string $title
 * @property string $address
 * @property float $longitude
 * @property float $latitude
 * @property int $status
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Ambulance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ambulance newQuery()
 * @method static Builder|Ambulance onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Ambulance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ambulance whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ambulance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ambulance whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ambulance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ambulance whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ambulance whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ambulance whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ambulance whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ambulance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ambulance whereUserId($value)
 * @method static Builder|Ambulance withTrashed()
 * @method static Builder|Ambulance withoutTrashed()
 * @mixin Eloquent
 */
class Ambulance extends Model
{
    use SoftDeletes;

    public $table = 'ambulances';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'address',
        'longitude',
        'latitude',
        'status'
    ];


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'address' => 'string',
        'longitude' => 'double',
        'latitude' => 'double',
        'status' => 'integer',
        'user_id' => 'integer'
    ];


    /**
     * @return BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
