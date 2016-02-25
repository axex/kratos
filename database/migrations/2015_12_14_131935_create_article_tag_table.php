<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    /*
    |--------------------------------------------------------------------------
    |
    |--------------------------------------------------------------------------
    | foreign()：外键
    | references()：参照字段
    | on()：参照表
    | onUpdate(): 更新时执行的动作
    | onDelete()：删除时的执行动作
    | 这是跟着删除，比如删除了某篇文章，我们将article_tag中包含article_id一样的记录也删除
    */
    public function up()
    {
        Schema::create('article_tag', function (Blueprint $table) {
            $table->integer('article_id')->unsigned()->index();
            $table->integer('tag_id')->unsigned()->index();
            $table->foreign('article_id')->references('id')->on('articles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['article_id', 'tag_id']); // 联合主键
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
        Schema::drop('article_tag');
    }
}
