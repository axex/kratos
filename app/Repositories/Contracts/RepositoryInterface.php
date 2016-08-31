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
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function update(array $attributes);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function findOrFail($id, $columns = ['*']);

}