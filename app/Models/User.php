<?php

namespace App\Models;

use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    use EntrustUserTrait {
        // EntrustUserTrait 和 Authorizable 中的 can 方法重名了, 所以使用 insteadof 操作符来解决冲突, 使用 EntrustUserTrait 的 can 方法
        EntrustUserTrait::can insteadof Authorizable;
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * $fillable 规定哪些字段可以被 create() 或 update() 赋值, $guarded 是相反
     * 如 User::create(['avatar' => 'abc']), 数据库中不会插入abc这条数据, 因为不在 $fillable 里
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guarded = ['role', 'password_confirmation'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function systemLogs()
    {
        return $this->hasMany(SystemLog::class);
    }


    // 调整器 当我们为模型上的 password 赋值时该调整器会被自动调用
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
