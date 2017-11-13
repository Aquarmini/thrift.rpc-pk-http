<?php

namespace App\Tasks\Test;

use App\Tasks\Task;
use App\Thrift\Clients\AppClient;
use App\Utils\Curl;
use Xin\Cli\Color;

class SingleDatabaseRequestTask extends Task
{

    public $laravelApi = 'http://laravel.pk.test.phalcon.app/api/db';

    public $phalconApi = 'http://phalcon.pk.test.phalcon.app/api/db';

    public function mainAction()
    {
        $count = 100;
        echo Color::colorize('同步请求接口' . $count . '次', Color::FG_CYAN) . PHP_EOL;

        $btime = microtime(true);
        for ($i = 0; $i < $count; $i++) {
            $res = Curl::json($this->laravelApi);
        }
        $etime = microtime(true);
        echo Color::colorize('Laravel处理时间为:' . ($etime - $btime), Color::FG_CYAN) . PHP_EOL;

        $btime = microtime(true);
        for ($i = 0; $i < $count; $i++) {
            $res = Curl::json($this->phalconApi);
        }
        $etime = microtime(true);
        echo Color::colorize('Phalcon处理时间为:' . ($etime - $btime), Color::FG_CYAN) . PHP_EOL;

        $btime = microtime(true);
        $client = AppClient::getInstance();
        for ($i = 0; $i < $count; $i++) {
            $res = $client->db();
        }
        $etime = microtime(true);
        echo Color::colorize('Thrift.Rpc处理时间为:' . ($etime - $btime), Color::FG_CYAN) . PHP_EOL;

    }

}

