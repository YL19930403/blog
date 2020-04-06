<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('hello',function() {
    return 'Hello , Welcome To Laravel';
});

Route::get('/user','UserController@index');


Route::match(['get','post'],'foo',function (){
    return 'This is a request from get or post';
});

Route::any('bar',function(){
    return 'This is a request from any HTTP verb';
});

Route::get('/user/{id}',function($id){
   return 'User' . $id;
});

//在路由中定义多个路由参数
Route::get('/posts/{post}/comments/{comment}',function($postId,$commentId){
    return $postId . '-' . $commentId;
});

//可选参数
route::get('/user2/{name?}', function($name='wudy'){
    return $name;
});

//正则约束
Route::get('/user3/{id}/{name}',function ($id,$name){
    // name 必须是字母且不能为空
    return '正则规范';
})->where(['id'=>'[0-9]+', 'name'=>'[a-z]+']);

//命名路由
//命名路由为生成 URL 或重定向提供了方便--- 在路由定义之后使用 name 方法链的方式来定义该路由的名称
Route::get('user/profile',function (){
   return 'my url: ' .route('profile');
})->name('profile');


//为控制器指定路由名称
Route::get('user/profile','UserController@showProfile')->name('profile');


//为命名路由生成 URL
Route::get('user/{id}/profile',function($id){
   $url = route('profile',['nos'=>$id]);
   return $url;
})->name('profile');

//自定义中间件路由
Route::get('user4/{age?}',function ($age=18){
    return $age;
})->middleware('token');


//路由分组 : 定义中间件
Route::group(['middleware'=>['blog','role:editor']], function (){
    Route::get('user5/{name?}', function ($name='wudy.yu'){
       return $name ;
    });

    Route::get('/view',function (){
       return 'aabbcc';
    });
});

//终端中间件
Route::get('user7/{age?}',function ($age=18){
    return '终端中间件';
});

//中间件VerifyCsrfToken避免CSRF攻击
//中间件组 web 中的中间件 VerifyCsrfToken 会自动为我们验证请求输入的 token 值和 Session 中存储的 token 是否一致，
//如果没有传递该字段或者传递过来的字段值和 Session 中存储的数值不一致，则会抛出异常
// 在浏览器访问： http://localhost:8080/form_without_csrf_token
// 在浏览器访问： http://localhost:8080/form_with_csrf_token
//注：CSRF 中间件只只作用于 routes/web.php 中定义的路由，因为该文件下的路由分配了 web 中间件组，而 VerifyCsrfToken 位于 web 中间件组中
//VerifyCsrfToken 中间件框架底层实现源码位于 ： vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/VerifyCsrfToken.php
Route::get('form_without_csrf_token',function (){
    return '<form method="Post" action="/hello_from_form"><button type="submit">提交</button></form>';
});

Route::get('form_with_csrf_token', function () {
    return '<form method="Post" action="/hello_from_form">' . csrf_field() . '<button type="submit">提交</button></form>';
});

Route::post('hello_from_form', function (){
    return 'hello laravel!';
});


//控制器路由
Route::get('user8/{id}','UserController@show' );

//资源路由
Route::resource('posts', 'PostController',['only' =>
    ['index','show','store','edit']
]);

//命名资源路由
//默认情况下，所有资源控制器动作都有一个路由名称，不过，我们可以通过传入 names 数组来覆盖这些默认的名称
//Route::resource('posts','PostController',['names' =>
//    ['create' => 'post.build']
//]) ;

//Route::resource('post', 'PostController', ['parameters' => [
//    'post' => 'post_id',
//]]);


//添加Cookie到相应
Route::get('cookie/add',function (){
    $minutes = 24 * 60;
    return response('欢迎你')->cookie('name','wudy余',$minutes);
});

Route::get('cookie/get',function (\Illuminate\Http\Request $request){
    $cookie = $request->cookie('name');
    dd($cookie);
});

//帖子
Route::get('post/create', 'PostController@create');
Route::get('post/index', 'PostController@index');
Route::post('post','PostController@store');
Route::get('post/list','PostController@list');


//评论
Route::get('comment/index', 'CommentController@index');


//swoole
Route::get('swoole/index', 'SwooleController@index');

//访问Notice控制器，做数据查询
Route::get('notice/{id}','NoticeController@index');

//redis链接
Route::get('user20/profile','UserController@showProfile');

//kafka 生产者 与消费者
Route::get('user21/produce','UserController@produce');
Route::get('user21/consume','UserController@consume');



//闭包示例
Route::get('user21/callback', 'UserController@callBack');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/home',function(){
//
//})->middleware('auth');


//第三方回掉函数
Route::get('/user/callback','UserController@thirdCallBack')->name('third');

//GET /oauth/clients:
//为认证用户返回所有客户端，这在展示用户客户端列表时很有用，可以让用户很容易编辑或删除客户端


Route::get('user/sendnoti','UserController@sendNoti')->name('noti') ;

//
Route::get('user22/profile','UserController@show2');

//页面布局:http://wudy.laravel.cn:8088/blade
Route::get('blade', function(){
   return view('child', ['name' => '湘科院']);
});


//tcpdf调用
Route::any('user/tcpdf/{id}', 'UserController@downloadPdf');





