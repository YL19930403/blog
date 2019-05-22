<?php
/**
 * Created by PhpStorm.
 * User: yuliang
 * Date: 2018/11/30
 * Time: 下午4:56
 */
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;


class ConsumerKafka extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consumer:kafka';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '处理异步kafka消息';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        $this->log('开始监听消息');
        $kafkaSer = new \App\http\Services\KafkaService();
        $kafkaSer->consumer($group=env('KAFKA_GROUP'), $topics=env('KAFKA_TOPIC'), $url=env('KAFKA_URL'));
//        app('kafkaService')->consumer($group=env('KAFKA_GROUP'), $topics=env('KAFKA_TOPIC'), $url=env('KAFKA_URL'));
        return $this;
    }

    private function log($msg=''){
        if(!$msg){
            return $this;
        }
        if(php_sapi_name() == 'cli' ){
            echo $msg, PHP_EOL;
        }

//        app('myLog')->lumenLog($msg, 'kafka_consumer');
        Log::debug($msg);
        return $this;
    }

    //接收的处理逻辑
    public function consumerData($value) {
        print_r($value);
    }


}
