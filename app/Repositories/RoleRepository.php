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
}