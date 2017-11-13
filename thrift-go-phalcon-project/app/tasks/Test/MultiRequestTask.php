<?php

namespace App\Tasks\Test;

use App\Tasks\Task;
use swoole_process;
use App\Thrift\Clients\AppClient;
use App\Utils\Curl;
use Xin\Cli\Color;

class MultiRequestTask extends Task
{

    public $laravelApi = 'http://laravel.pk.test.phalcon.app/api/version';

    public $phalconApi = 'http://phalcon.pk.test.phalcon.app/api/version';

    public function phalconAction()
    {
        $num = 10; // 进程数
        $count = 100; // 单进程调用方法次数
        echo Color::colorize($num . '个进程，同步请求接口' . $count . '次', Color::FG_CYAN) . PHP_EOL;

        $btime = microtime(true);
        for ($i = 0; $i < $num; $i++) {
            $process = new swoole_process([$this, 'phalconHandle']);
            $process->write($count);
            $process->start();
        }
        swoole_process::wait(true);
        $etime = microtime(true);
        echo Color::colorize('Phalcon处理时间为:' . ($etime - $btime), Color::FG_CYAN) . PHP_EOL;

    }

    public function laravelAction()
    {
        $num = 10; // 进程数
        $count = 100; // 单进程调用方法次数
        echo Color::colorize($num . '个进程，同步请求接口' . $count . '次', Color::FG_CYAN) . PHP_EOL;

        $btime = microtime(true);
        for ($i = 0; $i < $num; $i++) {
            $process = new swoole_process([$this, 'laravelHandle']);
            $process->write($count);
            $process->start();
        }
        swoole_process::wait(true);
        $etime = microtime(true);
        echo Color::colorize('Laravel处理时间为:' . ($etime - $btime), Color::FG_CYAN) . PHP_EOL;
    }

    public function rpcAction()
    {
        $num = 10; // 进程数
        $count = 100; // 单进程调用方法次数
        echo Color::colorize($num . '个进程，同步请求接口' . $count . '次', Color::FG_CYAN) . PHP_EOL;

        $btime = microtime(true);
        for ($i = 0; $i < $num; $i++) {
            $process = new swoole_process([$this, 'rpcHandle']);
            $process->write($count);
            $process->start();
        }
        swoole_process::wait(true);
        $etime = microtime(true);
        echo Color::colorize('Thrift.Rpc处理时间为:' . ($etime - $btime), Color::FG_CYAN) . PHP_EOL;

    }

    public function laravelHandle(swoole_process $worker)
    {
        swoole_event_add($worker->pipe, function ($pipe) use ($worker) {
            $recv = $worker->read();            //send data to master
            for ($i = 0; $i < $recv; $i++) {
                $res = Curl::json($this->laravelApi);
            }
            // echo Color::colorize('进程' . $worker->pid . '处理结束', Color::FG_CYAN) . PHP_EOL;
            $worker->exit(0);
            swoole_event_del($pipe);
        });
    }

    public function phalconHandle(swoole_process $worker)
    {
        swoole_event_add($worker->pipe, function ($pipe) use ($worker) {
            $recv = $worker->read();            //send data to master
            for ($i = 0; $i < $recv; $i++) {
                $res = Curl::json($this->phalconApi);
            }
            // echo Color::colorize('进程' . $worker->pid . '处理结束', Color::FG_CYAN) . PHP_EOL;
            $worker->exit(0);
            swoole_event_del($pipe);
        });
    }

    public function rpcHandle(swoole_process $worker)
    {
        swoole_event_add($worker->pipe, function ($pipe) use ($worker) {
            $recv = $worker->read();            //send data to master
            $client = AppClient::getInstance();
            for ($i = 0; $i < $recv; $i++) {
                $res = $client->version();
            }
            // echo Color::colorize('进程' . $worker->pid . '处理结束', Color::FG_CYAN) . PHP_EOL;
            $worker->exit(0);
            swoole_event_del($pipe);
        });
    }

}

