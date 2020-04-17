<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalSpecialty extends Model
{
    use SoftDeletes;

    public $table = 'medical_specialties';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'medical_id'
    ];


    public function medical()
    {
        return $this->belongsTo(MedicalField::class, 'medical_id');
    }


}
