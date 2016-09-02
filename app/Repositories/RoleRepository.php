<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\Criteria\Repository;

class RoleRepository extends Repository
{
    protected function model()
    {
        return Role::class;
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

}