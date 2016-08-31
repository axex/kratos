<?php

namespace App\Repositories\Eloquent;

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

    abstract protected function model($model = null);

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
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        return $this->model->get($columns);
    }
}