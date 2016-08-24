<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $user;

    /**
     * UserRepository constructor.
     * @param $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all()
    {
        $users = $this->user->latest()->get();
        return $users;
    }

    /**
     * 搜索用户
     *
     * @param string $name
     * @return mixed
     */
    public function search($name)
    {
        $users = $this->user->where('username', 'like', $name . '%')->orWhere('realname', 'like', $name . '%')->paginate(\Cache::get('page_size', 10));
        return $users;
    }

    /**
     * 用户分页
     *
     * @return mixed
     */
    public function paginate()
    {
        $users = $this->user->with('roles')->latest()->paginate(\Cache::get('page_size', 10));
        return $users;
    }

    /**
     * 新建用户
     *
     * @param array $attributes
     * @return static
     */
    public function create(array $attributes)
    {
        $user = $this->user->create($attributes);
        return $user;
    }

    /**
     * 查找指定用户
     *
     * @param int $id
     * @return mixed
     */
    public function findOrFail($id)
    {
        $user = $this->user->with('roles')->findOrFail($id);
        return $user;
    }

    /**
     * 更新用户资料
     *
     * @param $user
     * @param array $attributes
     * @return mixed
     */
    public function update($user, array $attributes)
    {
        return $user->update($attributes);
    }

    /**
     * 删除用户
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $user = $this->findOrFail($id);
        return $user->delete();
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