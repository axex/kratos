<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'admin',
            'realname' => '管理员',
            'email'    => 'admin@local.com',
            'password' => 'admin',
        ]);

        User::create([
            'username' => 'editor',
            'realname' => '编辑',
            'email'    => 'editor@local.com',
            'password' => 'editor',
        ]);

        User::create([
            'username' => 'demo',
            'realname' => '演示',
            'email'    => 'demo@local.com',
            'password' => 'demo',
        ]);

        User::get()->each(function ($user) {
            if ($user->username === 'admin') {
                $role = Role::where('name', 'Admin')->first();
                $user->roles()->sync([$role->id]);
            }

            if ($user->username === 'editor') {
                $role = Role::where('name', 'Editor')->first();
                $user->roles()->sync([$role->id]);
            }

            if ($user->username === 'demo') {
                $role = Role::where('name', 'Demo')->first();
                $user->roles()->sync([$role->id]);
            }
        });
    }
}
