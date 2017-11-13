<?php

namespace App\Tasks\Test;

use App\Models\TRpcPkHttp;
use App\Tasks\Task;
use Xin\Cli\Color;
use Phalcon\Text;

class InitTask extends Task
{

    public function mainAction()
    {
        echo Color::colorize('初始化数据...', Color::FG_BLUE) . PHP_EOL;
        for ($i = 0; $i < 100000; $i++) {
            $model = new TRpcPkHttp();
            $model->name = Text::random(12);
            $model->save();
        }
        echo Color::colorize('初始化数据完毕', Color::FG_CYAN) . PHP_EOL;
    }

}

