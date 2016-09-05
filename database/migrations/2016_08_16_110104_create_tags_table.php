<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();

            /**
             * 设置 timestamp 类型的字段默认时间
             * 因为标签涉及到批量插入, 批量插入使用 Query Builder 的 insert 方法, insert 不会自动维护 created_at 和 updated_at
             * 这三种写法效果一样
             */
            $table->timestamp('created_at')->useCurrent = true;  // 等同 $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tags');
    }
}
