<?php
/**
 * Created by PhpStorm.
 * User: yuliang
 * Date: 2020/4/7
 * Time: 下午4:33
 */

namespace App\Listeners;

use App\User;
use Illuminate\Contracts\Redis\Factory;

class CacheOrderInformation
{
    protected $redis;

    /**
     * CacheOrderInformation constructor.
     * @param Factory $redis
     */
    public function __construct(Factory $redis)
    {
        $this->redis = $redis;
    }
}