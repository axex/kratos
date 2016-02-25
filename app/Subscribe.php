<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
