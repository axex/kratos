<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| 前台首页
|--------------------------------------------------------------------------
*/

Route::get('/', ['as' => 'home', 'uses' => 'IndexController@index']);


/*
|--------------------------------------------------------------------------
| 订阅邮件
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'subscribe'], function () {

    # 订阅
    Route::post('', 'SubscribeController@index');

    # 修改订阅资料
    Route::get('profile/{confirm_code}', 'SubscribeController@profile');
    Route::post('profile', 'SubscribeController@updateProfile');

    # 邮箱确认订阅
    Route::get('resend/{confirm_code}', 'SubscribeController@resendEmail');
    Route::get('{confirm_code}/{email}', 'SubscribeController@confirmEmail');
});

# 取消订阅
Route::any('unsubscribe/{confirm_code}', ['as' => 'unsubscribe', 'uses' => 'SubscribeController@unsubscribe']);

# 期数详情页
Route::get('issue{issue}', ['as' => 'issue', 'uses' => 'IssueController@index']);
Route::get('search', ['as' => 'search', 'uses' => 'IssueController@search']);

# 投稿
Route::get('add', ['as' => 'add', 'uses' => 'SubmissionController@index']);
Route::post('add', 'SubmissionController@store');


/*
|--------------------------------------------------------------------------
| 登录注册找回密码等操作
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'auth'], function () {
    $authority = 'AuthorityController@';

    # 登录
    Route::get('login', ['as' => 'login', 'uses' => $authority . 'getLogin']);
    Route::post('login', $authority . 'postLogin');

    # 注册
    Route::get('register', ['as' => 'register', 'uses' => $authority . 'getRegister']);
    Route::post('register', $authority . 'postRegister');

    # 退出
    Route::get('logout', ['as' => 'logout', 'uses' => $authority . 'logout']);

    # 密码重置链接请求路由
    Route::get('reset/password', ['as' => 'reset.password', 'uses' => $authority . 'getEmail']);
    Route::post('reset/password', $authority . 'postEmail');

    # 密码重置路由
    Route::get('reset/confirm/{reset_code}', $authority . 'getReset');
    Route::post('reset/confirm', ['as' => 'reset.confirm', 'uses' => $authority . 'postReset']);
});


/*
|--------------------------------------------------------------------------
|  管理员后台 实现文章和用户等管理操作
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'backend', 'middleware' => 'auth', 'namespace' => 'Backend'], function () {

    $as = 'backend.';

    # 后台首页
    Route::get('/', ['as' => $as . 'console', 'uses' => 'AdminController@console']);

    #--------------------
    # 控制面板
    #--------------------

    # 个人资料
    Route::get('me', ['as' => $as . 'me', 'uses' => 'AdminMeController@me']);
    Route::post('me', 'AdminMeController@meProfile');

    # 头像上传
    Route::post('avatar', ['as' => $as . 'avatar', 'uses' => 'AdminMeController@avatarUpload']);


    #--------------------
    # 内容管理
    #--------------------

    # 期数
    Route::delete('issue/delete', ['as' => $as . 'issue.delete', 'uses' => 'AdminIssueController@batchDelete']);
    Route::resource('issue', 'AdminIssueController');

    # 文章
    Route::delete('article/delete', ['as' => $as . 'article.delete', 'uses' => 'AdminArticleController@batchDelete']);
    Route::resource('article', 'AdminArticleController');

    # 投稿
    Route::delete('submission/delete', ['as' => $as . 'submission.delete', 'uses' => 'AdminSubmissionController@batchDelete']);
    Route::resource('submission', 'AdminSubmissionController');

    # 分类
    Route::resource('category', 'AdminCategoryController');




    #--------------------
    # 用户管理
    #--------------------

    Route::group(['middleware' => 'deny403:manage_users'], function() use ($as) {

        # 后台员
        Route::resource('user', 'AdminUserController');

        # 订阅用户
        Route::delete('subscribe/delete', ['as' => $as . 'subscribe.delete', 'uses' => 'AdminSubscribeController@batchDelete']);
        Route::resource('subscribe', 'AdminSubscribeController');

        # 角色
        Route::resource('role', 'AdminRoleController');

        # 权限
        Route::resource('permission', 'AdminPermissionController');
    });


    #--------------------
    # 系统管理
    #--------------------

    Route::group(['middleware' => 'deny403:manage_system'], function() use ($as) {

        # 系统配置
        Route::get('system_settings', ['as' => $as . 'system.setting', 'uses' => 'AdminSystemSettingController@index']);
        Route::post('system_settings', 'AdminSystemSettingController@update');

        # 系统日志
        Route::get('system_logs', ['as' => $as . 'system.log.index', 'uses' => 'AdminSystemLogController@index']);
        Route::get('system_logs/{id}', ['as' => $as . 'system.log.show', 'uses' => 'AdminSystemLogController@show']);

        # 导出 excel
        Route::get('export/excel', ['as' => $as . 'export.excel', 'uses' => 'AdminSystemLogController@excelExport']);
    });
});