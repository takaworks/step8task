<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator; 
use \App\Models\TestProducts;

class TestValidateController extends Controller
{
    public function validateAddProduct(Request $request) {

        $validator = Validator::make($request->all(), [
            'txtFaddproduct' => 'required',
            'drpFaddcompany' => 'required',
            'txtFaddcost' => 'required|numeric',
            'txtFaddstock' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect('/home/add_product')
            ->withErrors($validator)
            ->withInput();
        } else {
            $hoge2 = new TestProducts();
            $companylist = $hoge2 -> getCompanyList();
            return view('addproduct') -> with ([
                'companylist' => $companylist
            ]);
        }
    }
}
