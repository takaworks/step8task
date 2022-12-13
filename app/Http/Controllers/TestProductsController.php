<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\TestProducts;
use Validator; 

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
        
        //製品名かメーカー名が記入されていたら検索、両方空白なら一覧表示
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

    public function showCompanylist() {

        $hoge = new TestProducts();
        $companylist = $hoge -> getCompanyList();

        return view('addproduct') -> with ([
            'companylist' => $companylist
        ]);
    }

    public function addProduct(Request $request)
    {
        //バリデーション
        $validator = Validator::make($request->all(), [
            'txtFaddproduct' => 'required',
            'drpFaddcompany' => 'required',
            'txtFaddprice' => 'required|numeric',
            'txtFaddstock' => 'required|integer',
        ]);

        if ($validator->fails()) {
        //バリデーションエラー有り

            return redirect('/home/add_product')
            ->withErrors($validator)
            ->withInput();
        } else {
        //バリデーションエラー無し

            $hoge1 = new TestProducts();
            $companylist = $hoge1 -> getCompanyList();

            // sampleディレクトリに画像を保存
            $file = $request->file('imgFaddimage');
            if (isset($file)) {
                $file_name = $file->getClientOriginalName();
                $file->storeAs('',$file_name);
            }

            //フォームに入力されたデータをDBに挿入
            $hoge2 = new TestProducts();
            if(isset($file_name)) {
                $file_name = 'http://localhost/step7task/storage/app/'.$file_name;
                $hoge2 -> insertProductList($request, $file_name);
            } else {
                $hoge2 -> insertProductList($request, "http://localhost/step7task/storage/app/noimage.png");
            }

            return view('addproduct') -> with ([
                'companylist' => $companylist
            ]);
        }
    }

}
