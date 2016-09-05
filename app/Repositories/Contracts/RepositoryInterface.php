<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * Creates instance of model.
     *
     * @return Model
     */
    public function makeModel();

    /**
     * @param array $with
     * @param string $by
     *
     * @return mixed
     *
     */
    public function withAndLatest($with = [], $by = 'created_at');

    /**
     * @param array $with
     * @param string $by
     *
     * @return mixed
     */
    public function all($with = [], $by = 'created_at');

    /**\
     * @param array $with
     * @param string $by
     * @param array $columns
     * @param string $pageName
     * @param null $page
     *
     * @return mixed
     */
    public function paging($with = [], $by = 'created_at', $columns = ['*'], $pageName = 'page', $page = null);

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * @param array $attributes
     * @param $id
     * @param string $column
     *
     * @return mixed
     */
    public function update(array $attributes, $id, $column = 'id');

    /**
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = ['*']);

    /**
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function findOrFail($id, $columns = ['*']);

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = ['*']);

    /**
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhere($where, $columns = ['*']);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id);


}