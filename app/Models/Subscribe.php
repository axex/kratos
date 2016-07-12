<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Subscribe
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $confirm_code 激活码
 * @property boolean $is_confirmed 是否激活
 * @property string $deleted_at 软删除时间
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscribe whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscribe whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscribe whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscribe whereConfirmCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscribe whereIsConfirmed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscribe whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscribe whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscribe whereUpdatedAt($value)
 */
class Subscribe extends Model
{
    use SoftDeletes;    // 软删除
    protected $table = 'subscribes';

    // 不允许写入数据库的字段
    protected $guarded = [];

    // 当获取被罗列在$dates数组中的属性时，它们会被自动转化为Carbon实例，允许你在属性上使用任何Carbon的方法：$user->delete_at->getTimestamp();
    // 默认$dates数组里面就有 created_at 和 updated_at
    protected $dates = ['delete_at'];
}
