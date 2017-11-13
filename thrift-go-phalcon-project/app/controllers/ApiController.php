<?php

namespace App\Controllers;

use App\Models\TRpcPkHttp;

class ApiController extends Controller
{

    public function versionAction()
    {
        echo 'v1.0.0';
    }

    public function dbAction()
    {
        $id = rand(1, 100000);
        $model = TRpcPkHttp::findFirst($id);
        echo $model->name;
    }

}

