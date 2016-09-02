<?php

use App\Models\SystemLog;
use App\Models\SystemSetting;

/*
|--------------------------------------------------------------------------
| 自定义公共函数库Helper
|--------------------------------------------------------------------------
|
|
|
*/

if (! function_exists('currentNav')) {
    /**
     * 根据路由 $route 处理当前导航URL，用于匹配导航高亮
     *
     * @param string $route 点分式路由别名
     * @return string 返回经过处理之后路径
     */
    function currentNav($route = '')
    { // dashboard.system.setting
        $routeArray = explode('.', $route);

        // 后台的路由前缀都是 dashboard, 出现 dashboard/*/ 的链接是一级链接
        if (is_array($routeArray) && count($routeArray) > 2) {

            // 二级链接
            // 如 kratos.com/dashboard/article  对应的路由别名是 dashboard.article.index, 所以碰到别名有 index 的要手动加上
            if ($routeArray[2] == 'index') {
                $route1 = $route;
            } else {
                // 三级链接
                $route1 = preg_replace('/[^\.]*$/i', 'index', $route, 1);
            }

            if (Route::getRoutes()->hasNamedRoute($route1)) {
                return route($route1);
            }

            return route($route);
        }
        return route($route);

    }
}

if (! function_exists('tap')) {
    /**
     * 5.3 版本提供的方法, 链式调用时动态加入查询语句
     * Call the given Closure with the given value then return the value.
     *
     * @param  mixed  $value
     * @param  callable  $callback
     * @return mixed
     */
    function tap($value, $callback)
    {
        $callback($value);

        return $value;
    }
}

if (! function_exists('writeToSystemLog')) {

    /**
     * 写入系统日志
     *
     * @param $log
     * @return bool
     */
    function writeToSystemLog($log) {
        if (is_array($log) && array_key_exists('content', $log)) { // 操作内容不存在则不写入
            $log = array_add($log, 'user_id', 0);
            $log = array_add($log, 'operator_ip', Request::getClientIp());  //操作者ip
            SystemLog::create($log);
            return true;
        }
        return false;
    }
}

if (! function_exists('getVerifyCode')) {

    /**
     * 获取激活码
     *
     * @return string
     */
    function getVerifyCode()
    {
        return str_random(48);
    }
}

if (! function_exists('getPerPageRows')) {

    /**
     * @return mixed
     */
    function getPerPageRows()
    {
        $setting = \Cache::rememberForever('systemSetting', function () {
            return (object) SystemSetting::first()->toArray();
        });

        return $setting->page_size;
    }
}
