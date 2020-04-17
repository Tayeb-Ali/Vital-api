<?php

namespace App\Repositories;

use App\Models\Wallet;
use App\Repositories\BaseRepository;

/**
 * Class WalletRepository
 * @package App\Repositories
 * @version February 27, 2020, 5:18 am UTC
*/

class WalletRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'balance',
        'user_id'
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
        return Wallet::class;
    }
}
