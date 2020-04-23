<?php

namespace App\Repositories;

use App\Models\MedicalSpecialty;
use App\Repositories\BaseRepository;

/**
 * Class MedicalSpecialtyRepository
 * @package App\Repositories
 * @version February 19, 2020, 4:54 pm UTC
*/

class MedicalSpecialtyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'medical_id'
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
        return MedicalSpecialty::class;
    }
}
