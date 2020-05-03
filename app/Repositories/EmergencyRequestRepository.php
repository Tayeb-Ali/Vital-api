<?php

namespace App\Repositories;

use App\EmergencyRequest;

/**
 * Class EmergencyRequestRepository
 * @package App\Repositories
 * @version February 19, 2020, 4:55 pm UTC
 */
class EmergencyRequestRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'reports',
        'reports_file',
        'doctor_id',
        'emergency_id',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EmergencyRequest::class;
    }
}
