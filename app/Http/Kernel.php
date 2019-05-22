<?php

namespace App\Http;

use App\Http\Middleware\CheckRole;
use App\Http\Middleware\CheckToken;
use App\Http\Middleware\StartSession;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    // 如果想要定义的中间件在每一个 HTTP 请求时都被执行
    protected $middleware = [
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,   //将字符串两端的空格清除
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,  //将空字符串转化为 null
        \App\Http\Middleware\TrustProxies::class,
//        CheckToken::class,
        StartSession::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    //通过指定一个键名的方式将相关中间件分到同一个组里面，这样可以更方便地将其分配到路由中，这可以通过使用 HTTP Kernel 提供的 $middlewareGroups 属性实现
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
        //自定义中间件组
        'blog' => [
            'token',
        ]
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        //如果你想要分配中间件到指定路由，首先应该在 app/Http/Kernel.php 文件中分配给该中间件一个 key，默认情况下，该类的 $routeMiddleware 属性包含了 Laravel 自带的中间件，要添加你自己的中间件，只需要将其追加到后面并为其分配一个 key
        'token' => CheckToken::class,
        'role' => CheckRole::class,
    ];
}
