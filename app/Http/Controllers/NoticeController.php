<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Illuminate\Support\Facades\DB;

class NoticeController extends Controller
{
    public function index(){
        $noticeObj = DB::select('select * from t_notice where id>0') ;
        dd($noticeObj);
    }
}
