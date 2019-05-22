<?php

namespace App\Http\Middleware;

use Closure;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
//    定义中间件
    public function handle($request, Closure $next)
    {
        if($request->input('token') != 'wudy.1993yu'){
            return redirect()->to('http:www.baidu.com/');
        }
        return $next($request);
    }

}
