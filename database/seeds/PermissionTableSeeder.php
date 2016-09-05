<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'manage_system',
            'display_name' => '管理系统',
        ]);

        Permission::create([
            'name' => 'manage_contents',
            'display_name' => '管理内容',
        ]);

        Permission::create([
            'name' => 'manage_users',
            'display_name' => '管理用户',
        ]);
    }
}
