<?php
/**
 * Created by PhpStorm.
 * User: yuliang
 * Date: 2019/7/13
 * Time: 上午8:29
 */

namespace App\Providers;

use App\handle\SwooleHandle;
use Illuminate\Support\ServiceProvider;

class SwooleHandleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }
    public function register()
    {
        $this->app->singleton('swoole',function(){
            return new SwooleHandle();
        });
    }
}