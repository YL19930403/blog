<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::match(['get','post'],'foo',function (){
    return 'This is a request from get or post';
});

Route::any('bar',function(){
    return 'This is a request from any HTTP verb';
});


//文件上传
Route::post('file/upload',function (\Illuminate\http\Request $request){
    if($request->hasFile('photo') && $request->file('photo')->isValid()){
        $photo = $request->file('photo');
        $extension = $photo->extension();
        $store_result = $photo->storeAs('photo','test.jpg');
        $output = [
            'extension' => $extension,
            'store_result' => $store_result
        ];
        print_r($output);exit();

    }
    exit('未获取到上传文件或上传过程出错');
});

//文件下载
Route::get('download/response',function (){
    return response()->download(storage_path('app/photo/test.jpg'),'测试图片') ;
});

//文件响应：非下载，俄日是直接在浏览器显示文件(图片)
Route::get('file/response',function (){
   return response()->file(storage_path('app/photo/test.jpg')) ;
});

//返回Response对象
Route::get('cookie/response',function (){
    return response('Hello World!',200)
        ->header('Content-Type','Text/plain')
        ->cookie('name','value',22) ;
});


//全局 Session 辅助函数
//使用全局的 PHP 函数 session 来获取和存储 Session 数据，如果只传递一个字符串参数到 session 方法，
//则返回该 Session 键对应的值；如果传递的参数是 key/value 键值对数组，则将这些数据保存到 Session
Route::get('home',function (){
    $value = session('key');
    $value = session('key', 'default');
    session(['key' => $value]) ;
});

Route::post('swoole/index', 'SwooleController@index');

