<?php

namespace App\Models;

use App\Models\EmergencyServiced;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="EmergencyRequest",
 *      required={"reports", "reports_file", "doctor_id", "emergency_id"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="reports",
 *          description="report",
 *          type="string"
 *      ), @SWG\Property(
 *          property="reports_file",
 *          description="report_file uploade",
 *          type="string"
 *      )
 *      @SWG\Property(
 *          property="doctor_id",
 *          description="dotor request servers",
 *          type="integer",
 *          format="int32"
 *      ),    @SWG\Property(
 *          property="emergency_id",
 *          description="man emergency request",
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
class EmergencyRequest extends Model
{
    use SoftDeletes;

    public $table = 'emergency_requests';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'reports',
        'reports_file',
        'doctor_id',
        'emergency_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'reports' => 'string',
        'reports_file' => 'string',
        'doctor_id' => 'integer',
        'emergency_id' => 'integer'
    ];


    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function emergency()
    {
        return $this->belongsTo(EmergencyServiced::class, 'emergency_id');
    }

}
