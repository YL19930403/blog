<?php
/**
 * Created by PhpStorm.
 * User: yuliang
 * Date: 2019/5/22
 * Time: 上午10:04
 */

// php  ObserverController.php


/**
 * 观察者接口
 */
interface InterfaceObserver
{
    function onListen($sender, $args);
    function getObserverName();
}

/**
 * 可被观察者接口
 * Interface InterfaceObservable
 */
interface InterfaceObservable
{
    function addObserver($observer);
    function removeObserver($observer_name);
}


/**
 * 观察者抽象类
 * Class Observer
 */
abstract class Observer implements InterfaceObserver
{
    protected $observer_name;
    function getObserverName()
    {
        var_dump('getObserverName');
        return $this->observer_name;
    }

    function onListen($sender, $args)
    {
        // TODO: Implement onListen() method.
    }
}


/**
 * 可被观察类
 * Class Observable
 */
abstract class Observable implements InterfaceObservable
{
    protected $observers = [];

    public function addObserver($observer)
    {
        var_dump('class-observable-add');
        if($observer instanceof InterfaceObserver)
        {
            var_dump('构造观察者数组');
            $this->observers[] = $observer;
        }
    }

    public function removeObserver($observer_name)
    {
        var_dump('class-observable-remove');
        foreach ($this->observers as $key=>$observer)
        {
            if($observer->getObserverName() === $observer_name)
            {
                array_splice($this->observers, $key, 1);
                return;
            }
        }
    }
}

/**
 * 模拟 可被观察类
 * Class A
 */
class A extends Observable
{
    public function __construct()
    {
        var_dump('construct-aaaa');
    }

    public function addListener($listener)
    {
        var_dump('AAAAAAA');
        foreach ($this->observers as $observer) {
            $observer->onListen($this, $listener);
        }
    }
}

/**
 * 模拟一个观察者类
 * Class B
 */
class B extends Observer
{
    protected $observer_name = 'B';

    public function __construct()
    {
        var_dump('construct-bbbb');
    }

    public function onListen($sender, $args)
    {
        var_dump($sender);
        echo "<br>";
        var_dump($args);
        echo "<br>";
    }
}

/**
 * 模拟另外一个观察者类
 * Class C
 */
class C extends Observer
{
    protected $observer_name = 'C';

    public function __construct()
    {
        var_dump('construct-cccc');
    }

    public function onListen($sender, $args)
    {
        var_dump($sender);
        echo "<br>";
        var_dump($args);
        echo "<br>";
    }
}

$a = new A();
//注入观察者
$a->addObserver(new B());
$a->addObserver(new C());

//可以看到观察者信息
$a->addListener('D');
////移除观察者
$a->removeObserver('B');

