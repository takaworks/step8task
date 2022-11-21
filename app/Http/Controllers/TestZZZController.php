<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZZZ;

class TestZZZController extends Controller
{
    // public function showList() {
    //     return view('welcome');
    // }

    public function showList() {
        // インスタンス生成
        $model = new ZZZ();
        $ZZ = $model->getZZZ();

        return view('welcome', ['XYZ' => $ZZ]);
    }
}
