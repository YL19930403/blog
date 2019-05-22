<?php
/**
 * Created by PhpStorm.
 * User: yuliang
 * Date: 2018/11/30
 * Time: 上午9:58
 */

namespace App\Http\Services;

use App\Console\Commands\ConsumerKafka;
use Kafka;

class KafkaService{
    public  function __construct()
    {
        date_default_timezone_set('PRC');
    }

    /**
     * Produce
     */
    public function Produce($topic, $value, $url){
        $config = \Kafka\ProducerConfig::getInstance();
        $config->setMetadataRefreshIntervalMs(10000);
        $config->setMetadataBrokerList($url);
        $config->setBrokerVersion('1.0.0');
        $config->setRequiredAck(1);
        $config->setIsAsyn(false);
        $config->setProduceInterval(500);

        $producer = new \Kafka\Producer(function () use($value, $topic){
            return [
                [
                    'topic' => $topic,
                    'value' => $value,
                    'key' => 'wudy',
                ],
            ];
        });
        $producer->success(function ($result){
            return 'success';
        });

        $producer->error(function ($errorCode){
            var_dump($errorCode);
        });

        $producer->send(true);

    }


    /**
     * Consumer
     */
    public function consumer($group, $topics, $url){
        $config = \Kafka\ConsumerConfig::getInstance();
        $config->setMetadataRefreshIntervalMs(500);
        $config->setMetadataBrokerList($url);
        $config->setGroupId('test');
        $config->setBrokerVersion('1.0.0');
        $config->setTopics([$topics]);
        $config->setOffsetReset('earliest');
        $consumer = new \Kafka\Consumer();
        $consumer->start(function($topic, $part, $message){
            echo 'receive a message ..\n';
            $comsumeKafka = new ConsumerKafka();
            $comsumeKafka->consumerData($message['message']['value']);//接收的处理逻辑
            var_dump($message['message']['value']);
        });

    }

}

