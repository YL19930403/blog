<?php

namespace App\Providers;


use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application Services.
     *
     * @return void
     */
    public function boot()
    {
        //扩展Blade，自定义指令 , 需要删除Blade缓存试图：php artisan view:clear
        Blade::directive('datetime', function ($expression){
           return "<?php echo date('Y-m-d H:i:s', $expression) ?>";
        });

        //Blade::if 方法通过闭包的方式快速定义自定义的条件指令
        Blade::if('env', function($environment){
            return app()->environment($environment);
        });

        //在视图间共享数据
        View::share('key', 'value');
    }

    /**
     * Register any application Services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
