<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('website_title')->comment('网站标题');
            $table->string('website_keywords')->comment('网站关键词');
            $table->string('website_dsec')->comment('网站描述');
            $table->string('website_icp')->comment('网站备案号');
            $table->string('page_size')->comment('后台分页大小');
            $table->string('system_version')->comment('系统版本号');
            $table->string('system_author')->comment('系统开发者');
            $table->string('system_author_website')->comment('系统开发者网站');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('system_settings');
    }
}
