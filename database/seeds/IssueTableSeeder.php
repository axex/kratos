<?php

use Illuminate\Database\Seeder;
use App\Models\Issue;

class IssueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $issues = factory(Issue::class)->times(30)->make();
        Issue::insert($issues->toArray());
    }
}
