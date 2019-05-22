<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Post extends Model
{

    public $timestamps = false;

    //帖子
    const CREATE_AT = 'create_time';
    const UPDATE_AT = 'modify_time';


    //帖子与用户（发帖人）是一对一关系
    /**
     * 获取关联到帖子的用户
     */
//    public function user()
//    {
//        return $this->belongsTo('App\User');
//    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    /**
     * 一对多关系
     * 获取博客文章的评论
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
