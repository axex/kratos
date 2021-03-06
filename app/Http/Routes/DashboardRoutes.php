<?php
namespace App\Http\Routes;

use Illuminate\Routing\Router;

class DashboardRoutes
{
    /*
    |--------------------------------------------------------------------------
    |  管理员后台 实现文章和用户等管理操作
    |--------------------------------------------------------------------------
    */
    public function map(Router $router)
    {
        $router->group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => 'auth', 'namespace' => 'Dashboard'], function ($router) {

            # 后台首页
            $router->get('/', ['as' => 'console', 'uses' => 'AdminController@console']);

            #--------------------
            # 控制面板
            #--------------------

            # 个人资料
            $router->get('me', ['as' => 'me', 'uses' => 'AdminMeController@me']);
            $router->post('me', 'AdminMeController@meProfile');

            # 头像上传
            $router->post('avatar', ['as' => 'avatar', 'uses' => 'AdminMeController@avatarUpload']);


            #--------------------
            # 内容管理
            #--------------------

            # 期数
            $router->delete('issue/delete', ['as' => 'issue.delete', 'uses' => 'AdminIssueController@batchDelete']);
            $router->resource('issue', 'AdminIssueController');

            # 文章
            $router->delete('article/delete', ['as' => 'article.delete', 'uses' => 'AdminArticleController@batchDelete']);
            $router->resource('article', 'AdminArticleController');

            # 投稿
            $router->delete('submission/delete', ['as' => 'submission.delete', 'uses' => 'AdminSubmissionController@batchDelete']);
            $router->get('submission', ['as' => 'submission.index', 'uses' => 'AdminSubmissionController@index']);
            $router->get('submission/{id}/edit', ['as' => 'submission.edit', 'uses' => 'AdminSubmissionController@edit']);
            $router->put('submission/{id}', ['as' => 'submission.update', 'uses' => 'AdminSubmissionController@update']);
            $router->delete('submission/{id}', ['as' => 'submission.destroy', 'uses' => 'AdminSubmissionController@destroy']);

            # 分类
            $router->resource('category', 'AdminCategoryController');


            #--------------------
            # 用户管理
            #--------------------

            $router->group(['middleware' => 'deny403:manage_users'], function($router) {

                # 后台员
                $router->resource('user', 'AdminUserController');

                # 订阅用户
                $router->delete('subscribe/delete', ['as' => 'subscribe.delete', 'uses' => 'AdminSubscribeController@batchDelete']);
                $router->resource('subscribe', 'AdminSubscribeController');

                # 角色
                $router->resource('role', 'AdminRoleController');

                # 权限
                $router->resource('permission', 'AdminPermissionController');
            });


            #--------------------
            # 系统管理
            #--------------------

            $router->group(['middleware' => 'deny403:manage_system'], function($router) {

                # 系统配置
                $router->get('system_settings', ['as' => 'system.setting', 'uses' => 'AdminSystemSettingController@index']);
                $router->post('system_settings', 'AdminSystemSettingController@update');

                # 系统日志
                $router->get('system_logs', ['as' => 'system.log.index', 'uses' => 'AdminSystemLogController@index']);
                $router->get('system_logs/{id}', ['as' => 'system.log.show', 'uses' => 'AdminSystemLogController@show']);

                # 导出 excel
                $router->get('export/excel', ['as' => 'export.excel', 'uses' => 'AdminSystemLogController@excelExport']);
            });
        });
    }
}