<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator; 

class TestValidateController extends Controller
{
    //商品追加時のバリデーションルール
    public function validateAddProduct($request) {
        $validator = Validator::make($request->all(), [
            'txtFaddproduct' => 'required',
            'drpFaddcompany' => 'required',
            'txtFaddprice' => 'required|numeric',
            'txtFaddstock' => 'required|integer',
        ]);

        return $validator;
    }

    //商品編集時のバリデーションルール
    public function validateEditProduct($request) {
        $validator = Validator::make($request->all(), [
            'txtFeditproduct' => 'required',
            'drpFeditcompany' => 'required',
            'txtFeditprice' => 'required|numeric',
            'txtFeditstock' => 'required|integer',
        ]);

        return $validator;
    }
}
