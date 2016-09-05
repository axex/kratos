<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContributeArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contribute_articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('desc')->nullable();
            $table->string('url')->comment('原文链接');
            $table->string('presenter')->nullable()->comment('推荐者');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contribute_articles');
    }
}
