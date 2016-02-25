<?php

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
    { // backend.system.setting
        $routeArray = explode('.', $route);
        // 后台的路由前缀都是 backend, 出现 backend/*/ 的链接是一级链接
        if (is_array($routeArray) && count($routeArray) >= 2) {
            // 二级链接
            // 如 kratos.com/backend/article  对应的路由别名是 backend.article.index, 所以碰到别名有 index 的要手动加上
            $route1 = $routeArray[0] . '.' . $routeArray[1] . '.index';
            if (Route::getRoutes()->hasNamedRoute($route1)) {
                return route($route1);
            }
            return route($route);
        }
        return route($route);

    }
}

if (! function_exists('formatArticle')) {

    /**
     * 格式化文章
     *
     * @param $request
     * @param $article
     * @return mixed
     */
    function formatArticle($request, $article)
    {
        $article->title = e($request->get('title'));
        $article->url = trim(e($request->get('url')));
        $article->presenter = trim(e($request->get('presenter')));
        $article->issue_id = e($request->get('issue_id'));
        $article->category_id = e($request->get('category_id'));
        $article->is_recomm = e($request->get('is_recomm'));
        $article->desc = strip_tags($request->get('desc'));

        if ($request->exists('is_check')) {
            $article->is_check = e($request->get('is_check'));
        }
        return $article;
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
            \App\SystemLog::create($log);
            return true;
        }
        return false;
    }
}