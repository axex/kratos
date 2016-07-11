<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class PermissionDenied
{
    /**
     * 权限不足抛出异常响应 中间件
     * 默认权限为 manage_contents
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param $permissions  权限
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions = '')
    {
        $permissions = empty($permissions) ? 'manage_contents' : $permissions;
        if (! $request->user()->can($permissions)) {
            return response()->view('dashboard.exceptions.deny403', [], 403);
        }
        return $next($request);
    }
}
