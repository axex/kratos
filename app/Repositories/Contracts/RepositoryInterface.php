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