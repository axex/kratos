<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublishingArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publishing_articles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('issue')->comment('期数');
            $table->unsignedInteger('category_id')->comment('栏目id');
            $table->string('title')->comment('文章标题');
            $table->string('desc')->nullable();
            $table->string('url')->comment('原文链接');
            $table->string('presenter')->nullable()->comment('推荐者');
            $table->boolean('is_recomm')->comment('是否推荐');
            $table->boolean('is_check')->default(1)->comment('是否审核');
            $table->index('title');
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('issue')->references('issue')->on('issues')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('publishing_articles');
    }
}
