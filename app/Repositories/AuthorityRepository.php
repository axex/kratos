<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthorityRepository
{
    protected $user;

    /**
     * AuthorityRepository constructor.
     * @param $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * 注册用户
     *
     * @param array $attributes
     * @return static
     */
    public function create(array $attributes)
    {
        return $this->user->create($attributes);
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


    /**
     * 验证登录
     *
     * @param string $username
     * @param string $password
     * @param bool $remember
     * @param bool $login
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
     * 根据邮箱查找用户
     *
     * @param string $email
     * @return \Illuminate\Database\Eloquent\Model|static|null
     */
    public function getUserWithEmail($email)
    {
        $user = User::where('email', $email)->first();
        return $user;
    }


    /**
     * 根据重置码查找用户
     *
     * @param string $resetCode
     * @return \Illuminate\Database\Eloquent\Model|static|null
     */
    public function getUserWithResetCode($resetCode)
    {
        $user = User::where('reset_code', $resetCode)->first();
        return $user;
    }

    /**
     * 重置密码
     *
     * @param User $user
     * @param array $attributes
     * @return mixed
     */
    public function update($user, array $attributes = [])
    {
        return $user->update($attributes);
    }
}