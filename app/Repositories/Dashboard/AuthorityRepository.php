<?php
namespace App\Repositories\Dashboard;

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

    public function user()
    {
        return Auth::user();
    }

    public function update($user, array $attributes)
    {
        return $user->update($attributes);
    }

}