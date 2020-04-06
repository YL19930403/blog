<?php
/**
 * Created by PhpStorm.
 * User: yuliang
 * Date: 2019/7/21
 * Time: 上午10:19
 */

namespace App\Http\Controllers;

use App;
use GuzzleHttp\Client;
use Illuminate\http\Request;


class ESController extends Controller
{

    //查询
    public function index(Request $request)
    {
        $searchKey = $request->input('searchKeys', '');
        $list = App\Models\School::search($searchKey)->where('query',['*school_name*', '*school_about*'])->paginate(10)->toArray();
        print_r($list);

    }

    //新增
    public function add(Request $request)
    {
        $searchKey = $request->input('searchKeys', '');
        $client = new Client();
        $url = config('scout.elasticsearch.hosts')[0] .'/'.config('scout.elasticsearch.index') . '/video';
        $data = [
            'name' => '李艳傻逼',
            'content' => '这个傻逼天天骂我，我好讨厌她',
            "cat_id" => 2,
            "image" => "https://blog.csdn.net/s",
            "url" => "https://blog.csdn.net/zwgdft/article/details/38333",
            "type" =>  1,
            "status" => 1,
            "video_id" => "635483726351827"
        ];

        $res = $client->post($url,[
            \GuzzleHttp\RequestOptions::JSON => $data
        ]);
        print_r($res);
    }







}