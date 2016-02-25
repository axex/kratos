<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('realname')->nullable();
            $table->string('email')->unique();
            $table->string('avatar')->nullable();
            $table->string('password', 60);
            $table->string('reset_code', 60)->nullable();
            $table->unsignedTinyInteger('is_lock')->default(0)->comment('是否锁定限制用户登录，1锁定,0正常');
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
