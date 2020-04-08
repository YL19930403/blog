<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 访问路由： wudy.laravel.cn:8082/posts
     */
    public function index()
    {
        //一对一
//        $user = Post::find(2)->user;
//        print_r($user);die;

        //一对多
//        $comments = Post::find(2)->comments;//->where('status', 1)->first();
//        print_r($comments);die;




        $posts = Post::all();
//        var_dump($posts);   //Illuminate\Database\Eloquent\Collection
        foreach ($posts as $post) {
            print_r( $post->toArray());
//            print_r( $post->id);
        }
    }

    public function list()
    {
        $request = new Request();
        $input = $request->all();
//        $input = $request->input('id');
        print_r($input);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        die('store');
        //编写验证逻辑
        $validateData = $request->validate([
           'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);
    }

    public function driver(){
        echo 'driver';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 访问路由： wudy.laravel.cn:8082/posts/2
     */
    public function show($id)
    {
        echo $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 访问路由： wudy.laravel.cn:8082/posts/2/edit
     */
    public function edit($id)
    {
        die('edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        die('update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        die('destrory');
    }

    public function transfer($id){
        echo $id;
        die('switch');
    }



}
