<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

//echo phpinfo();
//die('aaa');



define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
| 自动加载文件设置
*/

require __DIR__.'/../vendor/autoload.php';
/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
| 初始化服务容器
*/
$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
| kernel处理来访的请求，并且发送相应返回给用户浏览器
  通过服务容器生成一个kernel类的实例
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

//运行Kernel类的handle方法，主要动作是运行middleware和启动URL相关的Contrller
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$response->send();


$kernel->terminate($request, $response);

