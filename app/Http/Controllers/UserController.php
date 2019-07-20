<?php
/**
 * Created by PhpStorm.
 * User: yuliang
 * Date: 2018/8/30
 * Time: 上午10:04
 */

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Services\KafkaService;
use App\Notifications\InvoicePaid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use App\Notice;
use App\User;
use TCPDF;


// Kafka
require '../vendor/autoload.php';
date_default_timezone_set('PRC');

use Monolog\Formatter\JsonFormatter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Log\Writer;


class UserController extends BaseController{

    public function __construct()
    {
        //控制器中间件
        $this->middleware('token');
        //中间件auth只对show方法有效
//        $this->middleware('auth')->only('show');
        //中间件blog对 show以外的方法有效
//        $this->middleware('blog')->except('show');
    }

    public function index(){
        echo 'wudy';
    }

    //DelayQueue:延时队列   http://wudy.laravel.cn:8088/user22/profile?token=wudy.1993yu
    public function show2(){
        echo  phpinfo();
        die;
    }

    public function show(Request $request ,$id){

//        url : http://localhost:8080/user8/3?token=wudy.1993yu
//        return view('user.profile', ['user'=>User::findOrFail($id)]);
//        return $id.'控制器中间件';
        //从 Session 中获取数据的时候，还可以传递默认值作为第二个参数到 get 方法
//        $value = $request->session()->get('key','default') ;
//        $value = $request->session()->get('key',function (){
//           return 'default' ;
//        });


//        Redis::set('foo', 2);
//        echo Redis::get('foo');

        //redis
//        for( $i=0 ; $i<10000 ; $i++){
//            Redis::set('scan'.$i,$i);
//        }

        //使用 ? 占位符代表参数绑定
//        $notice = DB::select('select * from t_notice where status=?',[1]);
        //命名绑定
//        $notice = DB::select('select * from t_notice where status = :status', ['status'=>1]) ;
//        var_dump($notice);die;

        //插入语句
//       $res =  DB::insert('INSERT INTO t_notice (content,status,op_id,op_user,publish_start_time,publish_end_time,create_time,modify_time) VALUES(?,?,?,?,?,?,?,?)',['timo.yu',1,12,'timo','2018-09-18 11:23:12','2018-09-18 23:23:33','2018-09-18 13:23:12','2018-09-18 21:13:22']);
//       var_dump($res);die;

        //数据库事物
//       Db::transaction(function (){
//           DB::update('UPDATE t_notice set content = ? where id = ? ', ['我是wudy99', 38]) ;
//           DB::update('UPDATE t_notice  set content = ? where id = ?' ,['wudy是我',39]) ;
//        });

        //查询构建器
//        $notice = DB::table('t_notice')->get();
//        var_dump($notice) ;die;


        //获取一行/一列 , first 返回单个的StdClass 对象
//        $notice = DB::table('t_notice')->where('id',39)->first();
//        var_dump($notice) ;die;

        //使用 value 方法从结果中获取单个值，该方法会直接返回指定列的值
//        $res = DB::table('t_notice')->where('id',39)->value('content');
//        var_dump($res);die;

        //获取包含单个列值的数组
//        $contents = DB::table('t_notice')->pluck('content') ;
//        foreach ($contents as $content){
//            var_dump($content) ;
//        }

        //还可以在返回数组中为列值指定自定义键（该自定义键必须是该表的其它字段列名，否则会报错）：
//        $contents = DB::table('t_notice')->pluck('content','id');
//        foreach ($contents as $id=>$content ){
//            var_dump($id) ;
//            var_dump($content);
//        }


        //组块结果集:如果你需要处理成千上百条数据库记录，可以考虑使用 chunk 方法，该方法一次获取结果集的一小块，然后传递每一小块数据到闭包函数进行处理

//        DB::table('t_notice')->orderBy('id')->chunk(10,function ($notices){
//             foreach ($notices as $notice ){
//                 //把前面10条数据content全部转为：'peter是李强'
////                 print_r($notice) ;
//                 DB::update('UPDATE t_notice set content = ? where id = ? ', ['peter是李强',$notice->id]);
//             }
////             die;   //在这里可以看到只取出了10条数据
//        });


        //参数分组
        /*
        $res1 =  DB::table('t_notice')->where('id','=','39')
                                    ->orwhere(function ($query){
                                        $query->where('status','<>',1) ;
                                    })->get();

        $res2 = DB::table('SELECT * FROM t_notice where id = ? OR ( status <> ? ) ', [39, 1]) ;
        var_dump($res1);
        var_dump($res2);
        die;
        */

        //分页
//        $notice = DB::table('t_notice')->simplePaginate(5);
//        var_dump($notice);die;


        // php7 支持为负的字符串偏移量
//        var_dump("abcdef"[-2]);
//        var_dump(strpos("aabbcc", "b",-4));


        //pcntl
//        $pid = pcntl_fork();




        }

    public function produce(){ //$topic, $value, $url
        $topic = 'dog';
        $value = 'cy.chen';
        $url = '127.0.0.1:9092';

        $kafkaService = new KafkaService();
        $kafkaService->Produce($topic, $value, $url);

    }

    public function consume () {
        $group = 'consumeA';
        $topics = 'dog';
        $url = '127.0.0.1:9092';

        $kafkaService = new KafkaService();
        $kafkaService->consumer($group, $topics, $url);

    }


    public function showProfile(){

        //url： http://localhost:8080/user20/profile?token=wudy.1993yu
        //获取模型
        $notices = Notice::all();
//        foreach ($notices as $notice){
//            echo $notice->content;
//        }

        //添加额外约束
//        $notices = Notice::where('status',1)
//                        ->orderBy('id','desc')
//                        ->take(10)
//                        ->get();
//
//        foreach ($notices as $notice){
//            echo $notice->id;
//        }

//        foreach ($notices as $notice ){
//            echo $notice->id ;
//        }

        //组块结果集
//        Notice::chunk(10,function ($notis){
//            foreach ($notis as $noti ){
//                $noti->content = '我是wudy777';
//                $noti->save();
//            }
//        });

        //批量更新
//        Notice::where('status',1)
//            ->update(['content' => 'wudy999']);

        //通过status属性获取模型，如果不存在则会创建
//        Notice::firstOrCreate(['status' => 5],['content' => 'timo555']);

        //通过status=6获取数据，如果不存在则根据status和content创建新的实例
//        $notice = Notice::firstOrNew(['status' => 6],['content' => 'timo666']);
//        print_r($notice);


        //模型存在则更新，否则创建新的模型
        //如果有status=5, 并且content=timo555 的模型，则将其op_user设置为 timo,更新数据库，并返回该模型
        //如果没有则写入，并返回该模型
//       $res = Notice::updateOrCreate(['status' => 6, 'content'=>'timo666'] , ['op_user' => 'timo']);
//       print_r($res);
//        Schema::table('t_notice',function ($table){
//            $table->softDeletes();
//        });

        //加解密
//        $encrys = encrypt('我是wudy');
//        $a = Crypt::encryptString('hello world');
//        var_dump($a);
//        $b = Crypt::decryptString($a);
//        var_dump($b);

        //Hash算法加解密
//        $pwd = Hash::make('yuliang');
//        var_dump($pwd);
//        if(Hash::check('yuliang',$pwd)){
//            print_r('密码匹配正确');
//        }

       echo  phpinfo();
       die;


        //redis 接管 session,   keys * 查看
//        session()->put('abc', 'wudy.yu is a good boy');
//        var_dump(session()->get('abc'));


        //laravel日志
        //Monolog方式
//        $streamHandler = new Streamhandler(storage_path('logs/wudy_log/error.log'), Logger::INFO);
//        $streamHandler->setFormatter(new JsonFormatter());
//        $logger->pushHandler($streamHandler);
//        $blogger = (new BLogger());
//        $blogger->info('wudy的日志',['ret' => 20012, 'data' => []]);

        //Log方式
//        $error_log = [
//            'ret' => 2001,
//            'msg' => 'decore调用失败',
//            'data' => []
//        ];
//        Log::debug($error_log);


    }


    /**
     * 闭包示例
     */
    public function callBack(){
        // http://wudy.laravel.cn:8088/user21/callback?token=wudy.1993yu

//        $closuer = function($name){
//            return sprintf('Hello %s', $name);
//        };
//        echo $closuer("wudy");   //Hello wudy
//        var_dump($closuer instanceof Closure);   //bool(false)


//        function Car($name,$owner){
//            return function($statu) use ($name,$owner){
//              return sprintf("Car %s is %s  and myname is %s",$name,$statu,$owner);
//            };
//        }
//        //将车名封装在闭包中
//        $car = Car('bwm','wudy');
//        echo $car('running');  //Car bwm is running  and myname is wudy


        $person = new TestController();
        $person->addPerson('wudy', function(){
            $this->age = 25;
            $this->sex = 'man';
        });
        $person->display('wudy');

    }

    /*
     * 第三方请求的回掉函数
     */
    public function thirdCallBack(){

    }

    /*
     * 缓存
     */
    public function sendNoti(){
//       $value = Cache::get('key');
//        Storage::disk('local')->put('wudy.txt','Storage 写入的文件内容：我是wudy');

        echo 'aaa';die;
    }



    //获取PDF
    public function downloadPdf(Request $request, int $id)
    {
        $comments = Comment::where('id', $id)->get();
//        print_r($comments->toArray());
//        print_r(compact('comments'));  // 转为对象 'comments' => []

    }

    public function getWareAddress($address)
    {
        if (strlen($address) < 80) {
            return <<<Eof
        <td rowspan="2" colspan="2" style="font-size: 16px;width: 455px;line-height:60px;">{$address}</td>
Eof;
        } else {
            return <<<Eof
        <td rowspan="2" colspan="2" style="font-size: 16px;width: 455px;">{$address}</td>
Eof;
        }
    }


    public function getWareDetail($outWareDetail)
    {
        $temp = [];
        $goods = ['苹果','小米'];
        $attrs = ['红色','钢化玻璃'];
        for ($i=0; $i<2; $i++){
            $temp[$i] = [
                'key_num'    => $i++,
                'goods_name' => $goods[$i],
                'attr_name' => $attrs[$i],
                'goods_unit' => '无',
            ];
        }
    }

}



