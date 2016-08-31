<?php

namespace App\Listeners;

use App\Events\UserLogin;
use App\Events\UserLogout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 登录监听
     *
     * @param UserLogin $event
     */
    public function onUserLogin(UserLogin $event)
    {
        $user = $event->user;
        // 写入日志
        \Log::info('user ' . $user->username . '[' . $user->email . '] has login');
        $log = [
            'user_id' => $user->id,
            'url' => route('login'),
            'content' => '用户：' . $user->username . '[' . $user->email . '] 登录系统。',
        ];
        writeToSystemLog($log);
    }

    /**
     * 退出监听
     *
     * @param UserLogout $event
     */
    public function onUserLogout(UserLogout $event)
    {
        $user = $event->user;
        // 写入日志
        \Log::info('user ' . $user->username . '[' . $user->email . '] has logout');
        $log = [
            'user_id' => $user->id,
            'url' => route('logout'),
            'content' => '用户：' . $user->username . '[' . $user->email . '] 退出系统。',
        ];
        writeToSystemLog($log);
    }

    /**
     * 修改资料监听
     *
     * @param $event
     */
    public function onUserUpdate($event)
    {
        $user = $event->user;
        \Log::info('user ' . $user->username . '[' . $user->email . '] has update his/her personal information');
        $log = [
            'user_id' => $user->id,
            'url' => route('dashboard.me'),
            'content' => '用户：' . $user->username . '[' . $user->email . '] 更新了个人资料。',
        ];
        writeToSystemLog($log);
    }

    public function onAddUser($event)
    {
        $user = $event->user;
        \Log::info('user ' . $user->username . '[' . $user->email . '] has been created');
        $logs = [
            'user_id' => $user->id,
            'url' => route('dashboard.dashboard.user.create'),
            'content' => '创建新用户：' . $user->username . '[' . $user->email . ']'
        ];
        writeToSystemLog($logs);
    }

    /**
     * 要注册的订阅者
     *
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('App\Events\UserLogin', 'App\Listeners\UserEventListener@onUserLogin');
        $events->listen('App\Events\UserLogout', 'App\Listeners\UserEventListener@onUserLogout');
        $events->listen('App\Events\UserUpdate', 'App\Listeners\UserEventListener@onUserUpdate');
        $events->listen('App\Events\AddUser', 'App\Listeners\UserEventListener@onAddUser');
    }
}
