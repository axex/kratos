<?php

namespace App\Repositories\Criteria;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;

abstract class Repository implements RepositoryInterface
{
    protected $app;

    protected $model;

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    abstract protected function model();

    /**
     * Creates instance of model.
     *
     * @throws \LogicException
     *
     * @return Model
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \LogicException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * @param array $with
     * @param string $by
     *
     * @return $this
     */
    public function withAndLatest($with = [], $by = 'created_at')
    {
        $this->model = tap($this->model->latest($by), function ($query) use ($with) {
            if ($with) {
                $query->with($with);
            }
        });

        return $this;
    }

    /**
     * @param array $with
     * @param string $by
     *
     * @return mixed
     */
    public function all($with = [], $by = 'created_at')
    {
        return $this->withAndLatest($with, $by)->get();
    }

    /**
     * @param array $with
     * @param string $by
     * @param array $columns
     * @param string $pageName
     * @param null $page
     *
     * @return mixed
     */
    public function paging($with = [], $by = 'created_at', $columns = ['*'], $pageName = 'page', $page = null)
    {
        return $this->withAndLatest($with, $by)->paginate(getPerPageRows(), $columns, $pageName, $page);
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param array $attributes
     * @param $id
     * @param string $field
     * @param array $columns
     *
     * @return mixed
     *
     */
    public function update(array $attributes, $id, $field = 'id', $columns = ['*'])
    {
        return $this->findBy($field, $id, $columns)->update($attributes);
    }

    /**
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    /**
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function findOrFail($id, $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = ['*'])
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * @param array $where
     * @param string $operator
     * @param array $columns
     *
     * @return $this
     */
    public function findWhere($where, $operator = '=', $columns = ['*'])
    {
        foreach ($where as $field => $value) {
            $this->model = $this->model->where($field, $operator, $value);
        }

        return $this;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param $method
     * @param $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([$this->model, $method], $args);
    }
}