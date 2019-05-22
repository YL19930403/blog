<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{

    protected $table = 't_notice';  //表明
    protected $primaryKey = 'id'; //主键
    //默认情况下，Eloquent 期望 created_at 和 updated_at 已经存在于数据表中
    //如果你不想要这些 Laravel 自动管理的数据列，在模型类中设置 $timestamps 属性为 false
    public $timestamp = false;
    //自定义用于存储时间戳的字段名称
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'modify_time';
    //不能被赋值的属性
    protected $guarded = ['id'] ;

    //软删除
//    use SoftDeletes;
//    protected $dates = ['deleted_at'];






}
