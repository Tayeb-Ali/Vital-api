<?php

namespace App\Repositories;

use Exception;
use Illuminate\Container\Container as Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     *
     * @throws Exception
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Get searchable fields array
     *
     * @return array
     */
    abstract public function getFieldsSearchable();

    /**
     * Configure the Model
     *
     * @return string
     */
    abstract public function model();

    /**
     * Make Model instance
     *
     * @throws Exception
     *
     * @return Model
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * Paginate records for scaffold.
     *
     * @param int $perPage
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginate($perPage, $columns = ['*'])
    {
        $query = $this->allQuery();

        return $query->sortable(['name' => 'asc'])->paginate($perPage, $columns);
    }

    public function paginateSortable($sortable, $perPage, $columns = ['*'])
    {
        return $this->model->sortable([$sortable => 'asc'])->paginate($perPage, $columns);
    }

    public function withpaginateSortable($with, $sortable, $perPage, $columns = ['*'])
    {
        return $this->model->with($with)->sortable([$sortable => 'asc'])->paginate($perPage, $columns);
    }

    /**
     * @param array $with
     * @param $perPage
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function withPaginate($perPage, $with = [], $columns = ['*'])
    {
        return $this->model
            ->with($with)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, $columns);
    }

    /**
     * @param $where
     * @param $condition
     * @param $perPage
     * @param array $with
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function WhereWithPaginate($where, $condition, $perPage, $with = [], $columns = ['*'])
    {
        return $this->model
            ->where($where, $condition)
            ->with($with)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, $columns);
    }

    /**
     * @param $where
     * @param $condition
     * @param $perPage
     * @param array $with
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function wherePaginate($where, $condition, $perPage, $columns = ['*'])
    {
        return $this->model
            ->where($where, $condition)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, $columns);
    }

    /**
     * Build a query for retrieving all records.
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @return Builder
     */
    public function allQuery($search = [], $skip = null, $limit = null)
    {
        $query = $this->model->newQuery();

        if (count($search)) {
            foreach ($search as $key => $value) {
                if (in_array($key, $this->getFieldsSearchable())) {
                    $query->where($key, $value);
                }
            }
        }

        if (!is_null($skip)) {
            $query->skip($skip);
        }

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Retrieve all records with given filter criteria
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @param array $columns
     *
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function all($search = [], $skip = null, $limit = null, $columns = ['*'])
    {
        $query = $this->allQuery($search, $skip, $limit);

        return $query->get($columns);
    }


    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations)->orderBy('created_at', 'desc')->get();
    }

    public function authWith($relations)
    {
        $user = Auth::user()->id;
        return $this->model->where('user_id', $user)->with($relations)->orderBy('created_at', 'desc')->get();
    }
    public function whereWith($where, $condition, $relations)
    {
        return $this->model->where($where, $condition)->with($relations)->orderBy('created_at', 'desc')->get();
    }

    /**
     * Create model record
     *
     * @param array $input
     *
     * @return Model
     */
    public function createApi($input)
    {
        $user = Auth::user();
        if ($user) {
            $model = $this->model->newInstance($input);
            $model->user_id = $user->id;
            $model->save();

            return $model;
        }
        return $user;
    }


    /**
     * Create model record
     *
     * @param array $input
     *
     * @return Model
     */
    public function create($input)
    {
        $model = $this->model->newInstance($input);
        $model->save();

        return $model;
    }

    /**
     * Find model record for given id
     *
     * @param int $id
     * @param array $columns
     *
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function find($id, $columns = ['*'])
    {
        $query = $this->model->newQuery();

        return $query->find($id, $columns);
    }

    /**
     * Find model record for given id with relationships
     *
     * @param int $id
     * @param $relationship
     * @param array $columns
     *
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findWith($id, $relationship = [''], $columns = ['*'])
    {
        $query = $this->model->newQuery();

        return $query->with($relationship)->find($id, $columns);
    }

    /**
     * Update model record for given id
     *
     * @param array $input
     * @param int $id
     *
     * @return Builder|Builder[]|Collection|Model
     */
    public function update($input, $id)
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        $model->fill($input);

        $model->save();

        return $model;
    }

    /**
     * @param int $id
     *
     * @throws Exception
     *
     * @return bool|mixed|null
     */
    public function delete($id)
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        return $model->delete();
    }

//    public function userCheck()
//    {
//
//        try {
//            $user = JWTAuth::parseToken()->authenticate();
//            return $user;
//        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
//
//            return response()->json(["message" => "token is expired", 'status' => false]);
//
//        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
//            return response()->json(["message" => "token is invalid", 'status' => false]);
//            // do whatever you want to do if a token is invalid
//
//        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
//            return response()->json(["message" => "token is not present", 'status' => false]);
//            // do whatever you want to do if a token is not present
//        }
//    }
}
