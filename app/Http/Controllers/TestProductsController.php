<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\TestProducts;
use BadFunctionCallException;

class TestProductsController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    // 商品一覧ページ表示
    public function showIndexPage(Request $request) {
        // フォーム入力からデータ受け取り
        $product_name = $request -> txtFproduct;
        $company_name = $request -> drpFcompany;

        // メーカーリスト取得
        $company_list = $this->getCompanylist();
        $product_list = $this->searchProductList($product_name,$company_name);

        return view('home') -> with ([
            'product_name' => $product_name,
            'company_name' => $company_name,
            'product_list' => $product_list,
            'company_list' => $company_list
        ]);
    }

    // 商品追加ページ表示
    public function showAddProductPage() {
        return view('addproduct') -> with ([
            'company_list' => $this->getCompanylist()
        ]);
    }

    // 詳細ページ表示
    public function showDetailPage(Request $request)
    {
        $company_list = $this->getCompanylist();
        $id = $request->id;

        $hoge = new TestProducts();
        $product_detail = $hoge->getProductDetailDB($id);

        return view('detail',compact('id')) -> with ([
            'company_list' => $company_list,
            'product_detail' => $product_detail
        ]);
    }

    //////////////////////////////////////////////////
    // メーカー名 全取得(この関数からモデルとやり取り)  //
    //////////////////////////////////////////////////
    public function getCompanylist() {
        $hoge = new TestProducts();
        $company_list = $hoge -> getCompanyListDB();
        return $company_list;
    }

    //////////////////////////////////////////
    // 商品検索(この関数からモデルとやり取り)  //
    //////////////////////////////////////////
    public function searchProductList($product_name, $company_name) {
        $hoge = new TestProducts();
        $product_list = $hoge -> searchProductListDB($product_name, $company_name);
        return $product_list;
    }

    ////////////////////////////
    // 商品追加を押した時の処理 //
    ////////////////////////////
    public function addProduct(Request $request) {
        $aaa = app()->make('App\Http\Controllers\TestValidateController');
        $validator = $aaa->validateAddProduct($request);

        if ($validator->fails()) {
        //バリデーションエラー有り
            return redirect('/home/add_product')
            ->withErrors($validator)
            ->withInput();
        } else {
        //バリデーションエラー無し
            $company_list = $this->getCompanylist();
            $file = $request->file('imgFaddimage');

            //ファイルアップロードされた場合、storage\appに画像を保存
            if (isset($file)) {
                $file_name = $file->getClientOriginalName();
                $file->storeAs('', $file_name);
            }

            //フォームに入力されたデータをDBに挿入
            $hoge = new TestProducts();
            if(isset($file_name)) {
                $file_name = 'http://localhost/step7task/storage/app/'.$file_name;
                $hoge -> insertProductListDB($request, $file_name);
            } else {
                $hoge -> insertProductListDB($request, "http://localhost/step7task/storage/app/noimage.png");
            }

            return view('addproduct') -> with ([
                'company_list' => $company_list
            ]);
        }
    }

}
