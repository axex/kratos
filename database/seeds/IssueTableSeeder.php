<?php

use Illuminate\Database\Seeder;

class IssueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $issues = factory(\App\Issue::class)->times(30)->make();
        \App\Issue::insert($issues->toArray());
    }
}
