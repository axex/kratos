<?php
namespace App\Repositories;

use App\Models\SystemSetting;
use App\Repositories\Criteria\Repository;

class SystemSettingRepository extends Repository
{
    protected function model()
    {
        return SystemSetting::class;
    }

    public function first()
    {
        $settings = $this->model->first();
        return $settings;
    }
}