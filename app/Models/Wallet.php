<?php

namespace App\Models;

use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Wallet
 *
 * @SWG\Definition (
 *      definition="Wallet",
 *      required={"balance"},
 *      @SWG\Property(
 *          property="balance",
 *          description="balance",
 *          type="string"
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
 * @property int $balance
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User $employ
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet newQuery()
 * @method static Builder|Wallet onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet query()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereUserId($value)
 * @method static Builder|Wallet withTrashed()
 * @method static Builder|Wallet withoutTrashed()
 * @mixin Eloquent
 */
class Wallet extends Model
{
    use SoftDeletes;

    public $table = 'wallets';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'balance',
        'user_id'
    ];


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'balance' => 'integer',
        'user_id' => 'integer'
    ];


    public function createWallet()
    {
        $user = Auth::user()->id;
        $wallet = new Wallet();
        $wallet->balance = env('BALANCE');
        $wallet->user_id = $user;
        $wallet->save();
        return $wallet;
    }

    /**
     * @return BelongsTo
     **/
    public function employ()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
