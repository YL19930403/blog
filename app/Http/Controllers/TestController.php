<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    private $name=[];
    private $age;
    private $sex;
    public function addPerson($name, $personCallback){
        //将闭包对象绑定当前实例
        $this->name[$name] = $personCallback->bindTo($this, __CLASS__);
    }
    public function display($name){
        foreach($this->name as $key=>$callback){
            if($key == $name){
                //执行闭包对象，将闭包状态附加到类
                $callback();
            }
        }
        echo "name:{$name}\n";
        echo "age:{$this->age}\n";
        echo "sex:{$this->sex}\n";
    }
}


