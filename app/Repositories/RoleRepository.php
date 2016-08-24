<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository
{
    protected $role;

    /**
     * UserRepository constructor.
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function all()
    {
        $roles = $this->role->latest()->get();
        return $roles;
    }

    /**
     * 用户组分页
     *
     * @return mixed
     */
    public function paginate()
    {
        $roles = $this->role->latest()->paginate(\Cache::get('page_size', 10));
        return $roles;
    }

    /**
     * 新建用户组
     *
     * @param array $attributes
     * @return static
     */
    public function create(array $attributes)
    {
        $role = $this->role->create($attributes);
        return $role;
    }

    /**
     * 查找指定用户
     *
     * @param int $id
     * @return mixed
     */
    public function findOrFail($id)
    {
        $roles = $this->role->with('perms')->findOrFail($id);
        return $roles;
    }

    /**
     * 同步用户组权限
     *
     * @param $role
     * @param array $id
     */
    public function sync($role, array $id)
    {
        $role->perms()->sync($id);
    }

    /**
     * 更新用户组
     *
     * @param $role
     * @param array $attributes
     * @return mixed
     */
    public function update($role, array $attributes)
    {
        return $role->update($attributes);
    }

    /**
     * 删除用户组
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $role = $this->findOrFail($id);
        return $role->delete();
    }
}