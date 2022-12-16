<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\TestProducts;
use BadFunctionCallException;

class TestProductsController extends Controller {

    public function __construct() {
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
        return view('add') -> with ([
            'company_list' => $this->getCompanylist()
        ]);
    }

    // 詳細ページ表示
    public function showDetailPage(Request $request) {
        $company_list = $this->getCompanylist();
        $id = $request->id;

        $hoge = new TestProducts();
        $product_detail = $hoge->getProductDetailDB($id);

        return view('detail',compact('id')) -> with ([
            'company_list' => $company_list,
            'product_detail' => $product_detail
        ]);
    }

    // 商品情報編集表示
    public function showEditPage(Request $request) {
        $company_list = $this->getCompanylist();
        $id = $request->id;

        $hoge = new TestProducts();
        $product_detail = $hoge->getProductDetailDB($id);

        return view('edit',compact('id')) -> with ([
            'company_list' => $company_list,
            'product_detail' => $product_detail
        ]);
    }

    /////////////////////////////////
    // メーカー名 全取得(使いまわし) //
    /////////////////////////////////
    public function getCompanylist() {
        $hoge = new TestProducts();
        $company_list = $hoge -> getCompanyListDB();
        return $company_list;
    }

    //////////////////////////
    //  商品検索(使いまわし)  //
    //////////////////////////
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
            return redirect('/home/add')
            ->withErrors($validator)
            ->withInput();
        } else {
        //バリデーションエラー無し
            $file = $request->file('imgFaddimage');
            $hoge = new TestProducts();

            //ファイルアップロードされた場合、対象画像のパスをdbに格納
            //アップロード無しの場合、特定画像のパスをdbに格納
            if (isset($file)) {
                $file_name = $file->getClientOriginalName();
                $file->storeAs('', $file_name);

                $file_name = 'http://localhost/step7task/storage/app/'.$file_name;
                $hoge -> insertProductListDB($request, $file_name);
            } else {
                $hoge -> insertProductListDB($request, "http://localhost/step7task/storage/app/noimage.png");
            }
            
            return redirect()->route('admin.add.show')
            ->with('successMessage','データを追加しました。');
        }
    }

    /////////////////////////////////
    // 商品編集の更新を押した時の処理 //
    /////////////////////////////////
    public function editProduct(Request $request) {
        $aaa = app()->make('App\Http\Controllers\TestValidateController');
        $validator = $aaa->validateEditProduct($request);

        //クエリ文字列にあるidの値 ?id=xxx
        $id = $request->id;
        $hoge = new TestProducts();
        
        if ($validator->fails()) {
        //バリデーションエラー有り
            return redirect('/home/edit?id='.$id)
            ->withErrors($validator)
            ->withInput();
        } else {
        //バリデーションエラー有り
            $file = $request->file('imgFeditimage');
            
            $img_path = $hoge->getimgDB($request->txtFeditproductid);

            //ファイルアップロードされた場合、storage\appに画像を保存
            if (isset($file)) {
                $file_name = $file->getClientOriginalName();
                $file->storeAs('', $file_name);

                $file_name = 'http://localhost/step7task/storage/app/'.$file_name;
                $hoge -> editProductDB($request, $file_name);
            } else {
                $hoge -> editProductDB($request, $img_path->img_path);
            }

            return redirect('/home/edit?id='.$id)
            ->with('successMessage','データを更新しました。');
        }
    }
}
