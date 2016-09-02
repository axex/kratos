<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Criteria\Repository;

class UserRepository extends Repository
{
    protected function model()
    {
        return User::class;
    }

    /**
     * 搜索用户
     *
     * @param string $name
     *
     * @return mixed
     */
    public function search($name)
    {
        $users = $this->model->where('username', 'like', $name . '%')->orWhere('realname', 'like', $name . '%')->paginate(getPerPageRows());

        return $users;
    }

    /**
     * 获取指定用户的用户组 id
     *
     * @param $user
     * @return mixed
     */
    public function getRoleId($user)
    {
        return $user->roles()->value('id');
    }

    /**
     * 同步用户组
     *
     * @param $user
     * @param array $id
     */
    public function sync($user, array $id)
    {
        $user->roles()->sync($id);
    }

}