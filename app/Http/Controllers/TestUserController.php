<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\TestUser;

class TestUserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // フォーム入力からデータ受け取り
        $product_name = $request -> input_product_name;
        $company_name = $request -> input_company_name;

        // インスタンス生成
        $hoge1 = new TestUser();
        $hoge2 = new TestUser();
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
            'input_product_name' => $product_name,
            'input_company_name' => $company_name,
            'productlist' => $productlist,
            'companylist' => $companylist
        ]);
    }
}
