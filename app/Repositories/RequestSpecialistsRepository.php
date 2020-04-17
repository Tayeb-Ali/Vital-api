<?php

namespace App\Repositories;

use App\Models\RequestSpecialists;
use App\Repositories\BaseRepository;

/**
 * Class RequestSpecialistsRepository
 * @package App\Repositories
 * @version February 19, 2020, 5:59 pm UTC
*/

class RequestSpecialistsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'address',
        'start_time',
        'end_time',
        'number_of_hour',
        'latitude'
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
        return RequestSpecialists::class;
    }
}
