<?php

namespace App\Repositories;


use App\Models\Permission;

class PermissionRepository
{
    protected $permission;

    /**
     * PermissionRepository constructor.
     * @param Permission $permission
     */
    public function __construct(Permission $permission)
    {

        $this->permission = $permission;
    }

    public function all()
    {
        return $this->permission->get();
    }
}