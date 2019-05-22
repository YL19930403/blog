<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    //默认情况下，Laravel 框架生成的 Cookie 都经过了加密和签名，以免在客户端被篡改。如果你想要让特定的 Cookie 子集在生成时取消加密
    protected $except = [
        //
    ];
}
