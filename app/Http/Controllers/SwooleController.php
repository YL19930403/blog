<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SwooleController extends Controller
{

    private $maxProcess = 800;
    private $child;
    private $masterRedis;
    private $redis_task_wing = 'task:wing';//待处理队列


    public function __construct()
    {
        $this->middleware('token');
    }

    public function init()
    {
        pcntl_signal(SIGCHLD, array($this, "sig_handler"));
        set_time_limit(0);
        ini_set('default_socket_timeout', -1); ////队列处理不超时,解决redis报错:read error on connection
    }



    public function index()
    {
        $a = base_path() . '/vendor/swoole/ssl/websocket_server.php';
        echo $a ;die;
        $http = new swoole_server("127.0.0.1", 9501);
        $http->on("start", function ($server) {
            echo "Swoole http server is started at http://127.0.0.1:9501\n";
        });

        $http->on("request", function ($request, $response) {
            $response->header("Content-Type", "text/plain");
            $response->end("Hello World\n");
        });

        $http->start();
    }
}
