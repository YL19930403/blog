<?php

namespace App\Http\Middleware;

use Closure;

class StartSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    //终端中间件，可以理解为一个善后的后台处理中间件。有时候中间件可能需要在 HTTP 响应发送到浏览器之后做一些工作，
    //比如，Laravel 内置的 session 中间件会在响应发送到浏览器之后将 Session 数据写到存储器中，为了实现这个功能，需要定义一个终止中间件并添加 terminate 方法到这个中间件
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    //当调用中间件上的 terminate 方法时，Laravel 将会从服务容器中取出一个该中间件的新实例，如果你想要在调用 handle 和 terminate 方法时使用同一个中间件实例，
    //则需要使用容器提供的 singleton 方法以单例的方式将该中间件注册到容器中
    public function terminate($request, $response){
        $_SESSION['name'] = 'wudy'.rand(10,20);
//        print_r($_SESSION['name']) ;

    }
}
