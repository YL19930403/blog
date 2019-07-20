<?php
/**
 * Created by PhpStorm.
 * User: yuliang
 * Date: 2019/7/12
 * Time: 上午11:49
 */

namespace App\Http\Controllers;

use App\Console\Commands\Swoole;
use SebastianBergmann\Timer\Timer;

class OrderController
{
    public function submit()
    {
        $pdo = new \PDO("mysql:host=". env('DB_HOST') . ";dbname=" . env('DB_DATABASE') ,env('DB_USERNAME'), env('DB_PASSWORD'), [\PDO::ATTR_PERSISTENT => true]);
        $pdo->setAttribute(\PDO::ATTR_AUTOCOMMIT, 1);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $orderInfo = [
            'order_amount' => 10.92,
            'user_name' => 'wudy.yu',
            'order_status' => 1,
            'date_created' => 'now()',
            'product_lit' => [
                0 => [
                    'product_id' => 1,
                    'product_price' => 5.00,
                    'product_number' => 10,
                    'date_created' => 'now()'
                ],
                1 => [
                    'product_id' => 2,
                    'product_price' => 5.92,
                    'product_number' => 20,
                    'date_created' => 'now()'
                ]
            ]
        ];

        try{
            $pdo->beginTransaction();
            $sql = 'insert into t_order (order_amount, user_name, order_status) values(:orderAmount, :userName, :orderStatus)';
            $stmt = $pdo->prepare($sql);
            $affectedRows = $stmt->execute([':orderAmount' => $orderInfo['order_amount'], ':userName' => $orderInfo['user_name'], ':orderStatus' => $orderInfo['order_status']]);
            $orderId = $pdo->lastInsertId();
            if(!$affectedRows)
            {
                throw new \PDOException('Failure to submit order!');
            }

            foreach ($orderInfo['product_lit'] as $production)
            {
                $sqlProductDetail = ' insert into t_order_detail (order_id, product_id,product_price, product_number) VALUES(:orderId, :productId,:productPrice ,:productNumber)';
                $stmtProductDetail = $pdo->prepare($sqlProductDetail);
                $stmtProductDetail->execute([':orderId' => $orderId, ':productId' => $production['product_id'], ':productPrice' => $production['product_price'] , ':productNumber' => $production['product_number']]);

                $sqlCheck = ' select product_stock_number from t_product_stock where product_id=:productId ';
                $stmtCheck = $pdo->prepare($sqlCheck);
                $stmtCheck->execute([':productId' => $production['product_id']]);
                $rowCheck = $stmtCheck->fetch(\PDO::FETCH_ASSOC);
                if($rowCheck['product_stock_number'] < $production['product_number'])
                {
                    throw new \PDOException('Out of stock, Failure to submit order!');
                }

                $sqlProductStock = ' update t_product_stock set product_stock_number=product_stock_number-:productNumber where product_id=:productId';
                $stmtProductStock = $pdo->prepare($sqlProductStock);
                $stmtProductStock->execute([':productNumber' => $production['product_number'], ':productId' => $production['product_id']]);
                $affectedRowsProductStock =  $stmtProductStock->rowCount();

                //库存没有正常扣除，失败，库存表里的product_stock_number设置了为非负数
                //如果库存不足时，sql异常：SQLSTATE[22003]: Numeric value out of range: 1690 BIGINT UNSIGNED value is out of range in '(`test`.`csdn_product_stock`.`product_stock_number` - 20)'
                if($affectedRowsProductStock <= 0)
                {
                    throw new \PDOException('Out of stock, Failure to submit order!');
                }
            }
            echo "Successful, Order Id is：" . $orderId ."，Order Amount is：" . $orderInfo['order_amount'] . "。";

            $pdo->commit();
//            pclose(popen('php order_cancel.php -a ' . $orderId . ' &', 'w'));

        }catch(\PDOException $ex){
            echo $ex->getMessage();
            $pdo->rollBack();
        }
        $pdo = null;
    }


    public function cancel(int $order_id = 0)
    {
        try{
            $pdo = new \PDO("mysql:host=". env('DB_HOST') . ";dbname=" . env('DB_DATABASE') ,env('DB_USERNAME'), env('DB_PASSWORD'), [\PDO::ATTR_PERSISTENT => true]);
            $pdo->setAttribute(\PDO::ATTR_AUTOCOMMIT, 0);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);


            \Swoole\Timer::after(10000, function () use ( $pdo, $order_id){
                try{
                    $pdo->beginTransaction();//开启事务处理
                    $sql = " select order_status from t_order where order_id=:orderId";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(':orderId' => $order_id));
                    $row = $stmt->fetch(\PDO::FETCH_ASSOC);
                    if(isset($row['order_status']) && $row['order_status'] === 1)
                    {
                        $sqlOrderDetail = " select product_id, product_number from t_order_detail where order_id=:orderId";
                        $stmtOrderDetail = $pdo->prepare($sqlOrderDetail);
                        $stmtOrderDetail->execute(array(':orderId' => $order_id));
                        while($rowOrderDetail = $stmtOrderDetail->fetch(\PDO::FETCH_ASSOC))
                        {
                            $sqlRestoreStock = "update t_product_stock set product_stock_number=product_stock_number + :productNumber where product_id=:productId";
                            $stmtRestoreStock = $pdo->prepare($sqlRestoreStock);
                            $stmtRestoreStock->execute(array(':productNumber' => $rowOrderDetail['product_number'], ':productId' => $rowOrderDetail['product_id']));
                        }
                        $sqlRestoreOrder = " update t_order set order_status=:orderStatus where order_id=:orderId";
                        $stmtRestoreOrder = $pdo->prepare($sqlRestoreOrder);
                        $stmtRestoreOrder->execute(array(':orderStatus' => 0, ':orderId' => $order_id));
                    }
                    $pdo->commit();//提交事务
                }catch (\PDOException $e){
                    echo $e->getMessage();
                }
                $pdo = null;
            });


        }catch(\PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function appendLog($str)
    {
        $dir = 'log.txt';
        $fh = fopen($dir, "a");
        fwrite($fh, $str . "\n");
        fclose($fh);
    }

}