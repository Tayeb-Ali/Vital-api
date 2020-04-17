<?php

namespace App\Repositories;

use App\Models\Employ;
use App\Repositories\BaseRepository;

/**
 * Class EmployRepository
 * @package App\Repositories
 * @version February 19, 2020, 4:55 pm UTC
*/

class EmployRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'graduation_date',
        'birth_of_date',
        'medical_registration_number',
        'registration_date',
        'address',
        'years_of_experience',
        'cv',
        'user_id',
        'medical_fields_id'
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
        return Employ::class;
    }
}
