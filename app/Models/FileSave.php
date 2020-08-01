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
 * App\Models\FileSave
 *
 * @property int $id
 * @property string $title
 * @property string|null $image
 * @property string $content
 * @property int $notification
 * @property int $status
 * @property int $user_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|FileSave newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FileSave newQuery()
 * @method static Builder|FileSave onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FileSave query()
 * @method static \Illuminate\Database\Eloquent\Builder|FileSave whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileSave whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileSave whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileSave whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileSave whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileSave whereNotification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileSave whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileSave whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileSave whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileSave whereUserId($value)
 * @method static Builder|FileSave withTrashed()
 * @method static Builder|FileSave withoutTrashed()
 * @mixin Eloquent
 */
class FileSave extends Model
{
    use SoftDeletes;

    public $table = 'file_saves';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'url',
        'extension',
        'user_id',
        'emergency_id',
        'pharmacy_id',
        'employ_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'extension' => 'string',
        'user_id' => 'integer',
        'emergency_id' => 'integer',
        'pharmacy_id' => 'integer',
        'employ_id' => 'integer',
        'url' => 'string',
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
    public function emergency()
    {
        return $this->belongsTo(EmergencyRequest::class, 'emergency_id', 'id');
    }

    /**
     * @return BelongsTo
     **/
    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class, 'pharmacy_id', 'id');
    }

    /**
     * @return BelongsTo
     **/
    public function employ()
    {
        return $this->belongsTo(Employ::class, 'employ_id', 'id');
    }

}
