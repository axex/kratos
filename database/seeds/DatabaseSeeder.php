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
        $this->call(PublishingTagTableSeeder::class);
        $this->call(PublishingArticleTagTableSeeder::class);
        $this->call(ContributeArticleTableSeeder::class);
        $this->call(ContributeTagTableSeeder::class);
        $this->call(ContributeArticleTagTableSeeder::class);
        $this->call(SubscribeTableSeeder::class);
        $this->call(SystemSettingTableSeeder::class);

        Model::reguard();
    }
}
