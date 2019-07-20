<?php
/**
 * Created by PhpStorm.
 * User: yuliang
 * Date: 2019/7/13
 * Time: 上午8:32
 */

namespace App\Handle;

class SwooleHandle
{
    public function __construct()
    {

    }
    public function onOpen($serv, $request)
    {
        echo 'onOpen';
    }
    public function onMessage($serv,$frame)
    {
        echo 'onMessage';
    }
    public function onClose($serv,$fd)
    {
        echo 'onClose';
    }
}