<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(PermissionTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(IssueTableSeeder::class);
        $this->call(PublishingArticleTbaleSeeder::class);
        $this->call(ContributeArticleTableSeeder::class);
        $this->call(SubscribeTableSeeder::class);
        $this->call(SystemSettingTableSeeder::class);
        $this->call(TagTableSeeder::class);
        $this->call(TaggableTableSeeder::class);

        Model::reguard();
    }
}
