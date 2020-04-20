<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * @SWG\Definition(
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
