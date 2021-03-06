<?php
// +----------------------------------------------------------------------
// | AppHandler.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Thrift\Services;

use App\Models\TRpcPkHttp;
use Xin\Thrift\MicroService\AppIf;

class AppHandler extends Handler implements AppIf
{
    public function version()
    {
        return $this->config->version;
    }

    public function db()
    {
        $id = rand(1, 100000);
        $model = TRpcPkHttp::findFirst($id);
        return $model->name;
    }
}