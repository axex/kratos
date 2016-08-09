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

    public function create(array $attributes)
    {
        return $this->user->create($attributes);
    }

    public function login($user)
    {
        Auth::login($user);
    }

    public function attempt($username, $password, $remember = false, $login = true)
    {
        return Auth::attempt([
            'username' => $username,
            'password' => $password,
            'is_lock'  => 0
        ], $remember, $login);
    }
}