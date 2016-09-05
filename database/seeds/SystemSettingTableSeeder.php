<?php

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(SystemSetting::class)->create();
    }
}
