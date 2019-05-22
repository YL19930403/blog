<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApitokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\InvoicePaid;

class User extends Authenticatable
{
    use Notifiable,HasApitokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
     * 发送用户通知
     */
    public function sendUserNoti(){

    }

}
