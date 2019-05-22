<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;


class CommentController extends Controller
{
    //http://wudy.laravel.cn:8088/comment/index?token=wudy.1993yu
    public function index()
    {

//        phpinfo();die;

        $server = new swoole_server('0.0.0.0', 9501);



//        $comments = Comment::all();

        //1.条件查询
//        $comments = Comment::where('id', '>', 4)->take(10)->get();
//        print_r($comments);die;

        //2.cursor 方法允许你用游标来遍历数据库数据记录，而且只执行一个 SQL 查询。当处理大量数据时，cursor 方法可以用来极大地减少内存的消耗
//        foreach (Comment::where('id', '3')->cursor() as $comment) {
//            print_r($comment);
//        }

        //3.分块输出数据
//        Comment::chunk(4, function($comments){
//            foreach ($comments as $comment) {
//                print_r($comment);
//            }
//        });

        //4.获得单个 Model / 聚合数据
//        $comment = Comment::find(['id' => 1]);
//        print_r($comment);
//        $comment = Comment::where(['post_id' => 1])->get();
//        print_r($comment);

//        $comment = Comment::where(['post_id' => 1])->first();
//        print_r($comment);

//        $comment = Comment::find([1,2,3]);   // id in (1,2,3)
//        print_r($comment);

        //5.Not Found 异常:
        //当一个 Model 没找到时，我们希望抛出一个异常，这在路由和控制器类里是非常有用的。这时可以使用 findOrFail 或者 firstOrFail 方法
        //如果没找到结果的话，一个 Illuminate\Database\Eloquent\ModelNotFoundException 异常会被抛出：
//        $comment = Comment::where('post_id', '>', 1)->firstOrFail();
//        print_r($comment);


        //6.聚合数据
//        $count = Comment::where(['post_id' => 1])->count();
//        print_r($count);
//        $max_id = Comment::where(['post_id' => 1])->max('id');
//        print_r($max_id);

        //7.添加额外约束
//        $comments = Comment::where('post_id', 1)
//                            ->orderBy('modify_time', 'desc')
//                            ->take(2)
//                            ->get();
//        print_r($comments);

        //average
//        $aveg = Comment::where(['post_id' => 1])->avg('op_id');
//        print_r($aveg);

        //combine:
        //The combine method combines the keys of the collection with the values of another array or collection
//        $collection = collect(['name', 'age']);
//        $combine = $collection->combine(['wudy.yu', 26]);
//        print_r($combine->all());

        //crossJoin()
//        $collection = collect([1, 2]);
//        $matrix = $collection->crossJoin(['a', 'b']);
//        print_r($matrix->all());


        //dd: dumps the collection's items and ends execution of the script
//        $collection = collect(['John Doe', 'Jane Doe']);
//        $collection->dd();

        //diff :
//        $collection = collect([1, 2, 3, 4, 5]);
//        $diff = $collection->diff([2, 4, 6, 8]);
//        print_r($diff->all());

        //diffAssoc
//        $collection = collect([
//            'color' => 'orange',
//            'type' => 'fruit',
//            'remain' => 6
//        ]);
//
//        $diff = $collection->diffAssoc([
//            'color' => 'yellow',
//            'type' => 'fruit',
//            'remain' => 3,
//            'used' => 6
//        ]);
//        print_r($diff->all());

        //diffKeys
//        $collection = collect([
//            'one' => 10,
//            'two' => 20,
//            'three' => 30,
//            'four' => 40,
//            'five' => 50,
//        ]);
//
//        $diff = $collection->diffKeys([
//            'two' => 2,
//            'four' => 4,
//            'six' => 6,
//            'eight' => 8,
//        ]);
//        print_r($diff->all());

        //except: The except method returns all items in the collection except for those with the specified keys
//        $collection = collect(['product_id' => 1, 'price' => 100, 'discount' => false]);
//        $filtered = $collection->except(['price', 'discount']);
//        print_r($filtered->all());

        //filter : The filter method filters the collection using the given callback, keeping only those items that pass a given truth test
//        $collection = collect([1, 2, 3, 4]);
//        $filtered = $collection->filter(function ($value, $key) {
//            return $value > 2;
//        });
//        print_r($filtered->all());

//        $comments = Comment::where(['post_id' => 1])->get();
////        print_r($comments);die;
//        $filter = $comments->filter(function ($value, $key){
//            return $value->id > 2;
//        });
////        print_r($filter);
//        print_r($filter->toArray());


        //first
//        $comments = Comment::where(['post_id' => 1])->get();
//        $first = $comments->first(function($value, $key){
//                     return $value->id > 2;
//                 });
//        print_r($first);

        //firstWhere: returns the first element in the collection with the given key / value
//        $comments = Comment::where(['post_id' => 1])->get();
//        $result = $comments->firstWhere('id', 7);
//        print_r($result);


        //flatMap
//        $comments = Comment::where(['post_id' => 1])->get();
//        print_r($comments);die;
//        $result = objectToArray($comments);
//        print_r($result);die;

//        print_r($result);
//        $flattened =  $comments->flatMap(function($values){
//             return array_map('strtoupper', $values->toArray());
//
//        });
//        print_r($flattened);


//        echo phpinfo();


        //懒加载指定字段
//        $posts = App\Comment::with('comment:id,content')->get();
//        print_r($posts);

        //跳转指定的控制器并附带参数
//        return redirect()->action('PostController@list')->withInput(['id' => 11]);

//        $commentModel = (new Comment());

        //通过id获取，如果不存在则通过给定属性创建新实例
//        $comments = Comment::firstOrCreate(['id' => 11,'post_id' => 1,'content' => '你就像那一把火，烧的法国人痛哭流涕', 'op_id' => 10,'op_user' => '毛新宇', 'modify_user' => 'mao.xinyu']);
//        print_r($comments);

        //如果模型已存在则更新，否则就创建(获取sql输出)
        //如果有对帖子2的评论，则status更新为0
//        $result = Comment::updateOrCreate(['post_id' => 2], ['status' => 0]);
//        DB::connection()->enableQueryLog();
//        $querys = DB::getQueryLog();
//        print_r($querys);

        //删除模型(物理删除)
//        $comment = Comment::find(13);
//        $comment->delete();


        //通过主键删除模型
//        $result = Comment::where('post_id', 3)->delete();
//        print_r($result);


        //一对多访问
//        $comment = Comment::find(1);
//        echo $comment->post->content;
//        die;


    }





}

