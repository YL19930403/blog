<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{

    use SoftDeletes;
    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    //评论
//    protected $table = 'my_comments'; //自定义表明

    //默认情况下，Eloquent 期望 created_at 和 updated_at 已经存在于数据表中，
    //如果你不想要这些 Laravel 自动管理的数据列，在模型类中设置 $timestamps 属性为 false
    /**
     * 表明模型是否应该被打上时间戳
     * @var bool
     */
    public $timestamps = false;

    //自定义用于存储时间戳的字段名称
    const CREATE_AT = 'create_time';
    const UPDATE_AT = 'modify_time';

    protected $fillable = ['id','post_id', 'content','op_id','op_user','status','modify_user'];

    /**
     * 要更新的所有关联表
     *
     * @var array
     */
//    protected $touches = ['post'];

    public function post()
    {
        return $this->belongsTo('App\Post', 'post_id', 'id');

        //关联时使用withDefault()
//        在调用关联时，如果另一个模型不存在，系统会抛出一个致命错误，例如 $comment->post->title，那么我们就需要使用withDefault()
//        return $this->belongsTo(Post::class)->withDefault();

        //
    }

}
