<?php

namespace App\Repositories;

use App\Models\Blog;

/**
 * Class BlogRepository
 * @package App\Repositories
 * @version Jun 19, 2020, 4:55 pm UTC
 */
class BlogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'content',
        'image',
        'status',
        'notification',
        'user_id',
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
        return Blog::class;
    }
}
