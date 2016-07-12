<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SystemLog
 *
 * @property integer $id
 * @property integer $user_id 用户id（为0表示系统级操作，其它一般为管理型用户操作）
 * @property string $url 操作的url
 * @property string $content 操作内容
 * @property string $operator_ip 操作者ip
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SystemLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SystemLog whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SystemLog whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SystemLog whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SystemLog whereOperatorIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SystemLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SystemLog whereUpdatedAt($value)
 */
class SystemLog extends Model
{
    protected $table = 'system_logs';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
