<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        if(Auth::check()){
//            print_r('用户已经登录');
//        }else{
            return view('home');
//        }
    }

    //重定向路径需要自定义生成逻辑可以定义一个 redirectTo 方法来取代 redirectTo 属性
    public function redirectTo(){
        return '/path';
    }
}
