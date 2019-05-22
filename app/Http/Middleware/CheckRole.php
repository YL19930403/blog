<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    //中间件还可以接收额外的自定义参数，例如，如果应用需要在执行给定动作之前验证认证用户是否拥有指定的角色，可以创建一个 CheckRole 来接收角色名作为额外参数。
    public function handle($request, Closure $next, $role)
    {
        if(!$request->user()->hasRole($role)){
            return redirect()->to('http://www.baidu.com');
        }
        return $next($request);
    }


}
