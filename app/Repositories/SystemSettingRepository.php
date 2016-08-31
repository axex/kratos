<?php
namespace App\Repositories;

use App\Models\SystemSetting;

class SystemSettingRepository
{
    protected $setting;

    /**
     * SystemSettingRepository constructor.
     * @param SystemSetting $setting
     */
    public function __construct(SystemSetting $setting)
    {
        $this->setting = $setting;
    }

    public function first()
    {
        $settings = $this->setting->first();
        return $settings;
    }

    /**
     * 更新系统配置
     *
     * @param array $attributes
     * @return mixed
     */
    public function update(array $attributes)
    {
        $setting = $this->first();
        return $setting->update($attributes);
    }
}