<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Criteria\Repository;
use Illuminate\Support\Facades\Auth;

class AuthorityRepository extends Repository
{

    protected function model()
    {
        return User::class;
    }

    /**
     * @param $user
     */
    public function login($user)
    {
        Auth::login($user);
    }

    public function logout()
    {
        Auth::logout();
    }

    public function user()
    {
        return Auth::user();
    }

    /**
     * 验证登录
     *
     * @param string $username
     * @param string $password
     * @param bool $remember
     * @param bool $login
     *
     * @return bool
     */
    public function attempt($username, $password, $remember = false, $login = true)
    {
        return Auth::attempt([
            'username' => $username,
            'password' => $password,
            'is_lock'  => 0
        ], $remember, $login);
    }

    /**
     * 查找用户
     *
     * @param $attribute
     * @param $value
     *
     * @return mixed
     */
    public function getUser($attribute, $value)
    {
        $user = $this->findBy($attribute, $value);

        return $user;
    }
}