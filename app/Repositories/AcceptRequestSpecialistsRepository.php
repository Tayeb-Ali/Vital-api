<?php

namespace App\Repositories;

use App\Models\AcceptRequestSpecialists;
use App\Repositories\BaseRepository;

/**
 * Class AcceptRequestSpecialistsRepository
 * @package App\Repositories
 * @version February 19, 2020, 5:27 pm UTC
*/

class AcceptRequestSpecialistsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'note',
        'recommendation',
        'rating'
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
        return AcceptRequestSpecialists::class;
    }
}
