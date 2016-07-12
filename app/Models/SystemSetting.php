<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SystemSetting
 *
 * @property integer $id
 * @property string $name 配置选项名
 * @property string $value 配置选项值
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SystemSetting whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SystemSetting whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SystemSetting whereValue($value)
 */
class SystemSetting extends Model
{
    protected $guarded = [];
    public $timestamps = false;
}
