<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\TestProducts;

class TestProductsController extends Controller
{
    public function index(Request $request) {
        // フォーム入力からデータ受け取り
        $product_name = $request -> txtFproduct;
        $company_name = $request -> drpFcompany;

        // インスタンス生成
        $hoge1 = new TestProducts();
        $hoge2 = new TestProducts();
        $productlist = $hoge1 -> getProductList();
        $companylist = $hoge2 -> getCompanyList();
        
        if (isset($product_name) or isset($company_name)) {
            $productlist = $hoge1 -> searchProductList($product_name,$company_name);
            $companylist = $hoge2 -> getCompanyList();
        } else {
            $productlist = $hoge1 -> getProductList();
            $companylist = $hoge2 -> getCompanyList();
        }


        return view('home') -> with ([
            'product_name' => $product_name,
            'company_name' => $company_name,
            'productlist' => $productlist,
            'companylist' => $companylist
        ]);
    }

    public function showAddProduct() {

        $hoge2 = new TestProducts();
        $companylist = $hoge2 -> getCompanyList();

        return view('addproduct') -> with ([
            'companylist' => $companylist
        ]);
    }

}
