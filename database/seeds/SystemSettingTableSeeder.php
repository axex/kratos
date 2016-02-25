<?php

use App\SystemSetting;
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
        SystemSetting::create([
            'name' => 'website_title',
            'value' => 'Kratos'
        ]);

        SystemSetting::create([
            'name' => 'website_keywords',
            'value' => 'K'
        ]);

        SystemSetting::create([
            'name' => 'website_dsec',
            'value' => ''
        ]);

        SystemSetting::create([
            'name' => 'website_icp',
            'value' => '11111'
        ]);

        SystemSetting::create([
            'name' => 'page_size',
            'value' => '10'
        ]);

        SystemSetting::create([
            'name' => 'system_version',
            'value' => 'alpha_1.0'
        ]);

        SystemSetting::create([
            'name' => 'system_author',
            'value' => 'Kratos'
        ]);

        SystemSetting::create([
            'name' => 'system_author_website',
            'value' => 'Kratos'
        ]);
    }
}
