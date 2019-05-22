<?php
/**
 * Created by PhpStorm.
 * User: yuliang
 * Date: 2019/4/21
 * Time: 下午9:04
 */

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Events\QueryExecuted;

class SqlListener
{
    public function __construct()
    {
    }

    public function handle(QueryExecuted $queryExecuted)
    {
        $sql = str_replace("?","'%s'", $queryExecuted->sql);
        $log = vsprintf($sql, $queryExecuted->bindings);
        $log = '[' . date('Y-m-d H:i:s') . ']' . $log . "\r\n";
        $filepath = storage_path('logs/sql.log');
        file_put_contents($filepath, $log, FILE_APPEND);
//        Log::useDailyFiles($filepath, 5, 'notice');
        Log::notice($log);
    }
}
