<?php
namespace App\Http\Routes;

use Illuminate\Routing\Router;

class FrontendRoutes
{
    public function map(Router $router)
    {
        # 前台首页
        $router->get('/', ['as' => 'home', 'uses' => 'IndexController@index']);

        /*
        |--------------------------------------------------------------------------
        | 订阅邮件
        |--------------------------------------------------------------------------
        */

        $router->group(['prefix' => 'subscribe'], function ($router) {

            # 订阅
            $router->post('', 'SubscribeController@index');

            # 修改订阅资料
            $router->get('profile/{confirm_code}', 'SubscribeController@profile');
            $router->put('profile', 'SubscribeController@updateProfile');

            # 邮箱确认订阅
            $router->get('resend/{confirm_code}', 'SubscribeController@resendEmail');
            $router->get('{confirm_code}/{email}', 'SubscribeController@confirmEmail');
        });

        # 取消订阅
        $router->get('unsubscribe/{confirm_code}', ['as' => 'unsubscribe', 'uses' => 'SubscribeController@unsubscribe']);
        $router->delete('unsubscribe/{confirm_code}', 'SubscribeController@delete');

        # 期数详情页
        $router->get('issue{issue}', ['as' => 'issue', 'uses' => 'IssueController@index']);
        $router->get('search', ['as' => 'search', 'uses' => 'IssueController@search']);

        # 投稿
        $router->get('add', ['as' => 'add', 'uses' => 'SubmissionController@index']);
        $router->post('add', 'SubmissionController@store');


        /*
        |--------------------------------------------------------------------------
        | 登录注册找回密码等操作
        |--------------------------------------------------------------------------
        */

        $router->group(['prefix' => 'auth'], function ($router) {
            $authority = 'AuthorityController@';

            # 登录
            $router->get('login', ['as' => 'login', 'uses' => $authority . 'getLogin']);
            $router->post('login', $authority . 'postLogin');

            # 注册
            $router->get('register', ['as' => 'register', 'uses' => $authority . 'getRegister']);
            $router->post('register', $authority . 'postRegister');

            # 退出
            $router->get('logout', ['as' => 'logout', 'uses' => $authority . 'logout']);

            # 密码重置链接请求路由
            $router->get('reset/password', ['as' => 'reset.password', 'uses' => $authority . 'getEmail']);
            $router->post('reset/password', $authority . 'postEmail');

            # 密码重置路由
            $router->get('reset/confirm/{reset_code}', $authority . 'getReset');
            $router->post('reset/confirm', ['as' => 'reset.confirm', 'uses' => $authority . 'postReset']);
        });
    }
}