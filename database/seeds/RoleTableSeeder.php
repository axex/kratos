<?php

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Admin',
            'display_name' => '超级管理员',
        ]);

        Role::create([
            'name' => 'Editor',
            'display_name' => '编辑',
        ]);

        Role::create([
            'name' => 'Demo',
            'display_name' => '演示',
        ]);


        Role::get()->each(function ($role) {
            if ($role->name === 'Admin') {
                $permissions = Permission::get()->pluck('id')->all();
                $role->perms()->sync($permissions);
            }

            if ($role->name === 'Editor') {
                $permissions = Permission::where('name', 'manage_contents')->first();
                $role->perms()->sync([$permissions->id]);
            }
        });
    }
}
