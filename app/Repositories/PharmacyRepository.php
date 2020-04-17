<?php

namespace App\Repositories;

use App\Models\Pharmacy;
use App\Repositories\BaseRepository;

/**
 * Class PharmacyRepository
 * @package App\Repositories
 * @version March 24, 2020, 7:51 pm UTC
*/

class PharmacyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'address',
        'dose',
        'company',
        'type',
        'user_id',
        'pharmacy_id'
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
        return Pharmacy::class;
    }
}
