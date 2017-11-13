<?php

namespace App\Http\Controllers;

use App\Models\TRpcPkHttp;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function version()
    {
        echo 'v1.0.0';
    }

    public function db()
    {
        $id = rand(1, 100000);
        $model = TRpcPkHttp::where('id', $id)->first();
        echo $model->name;
    }
}
