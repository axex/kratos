<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Repositories\Criteria\Repository;

class PermissionRepository extends Repository
{
    protected function model()
    {
        return Permission::class;
    }
}