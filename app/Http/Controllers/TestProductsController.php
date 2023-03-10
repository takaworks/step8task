<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\TestProducts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class TestProductsController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    // 商品一覧ページ表示
    public function showIndexPage(Request $request) {
        // セレクトボックス用　メーカーリスト取得
        $company_list = $this->getCompanylist();

        // test_home.bladeを表示
        return view('test_home') -> with ([
            'company_list' => $company_list,
        ]);
    }

    // 商品追加ページ表示
    public function showAddProductPage() {
        return view('test_add') -> with ([
            'company_list' => $this->getCompanylist()
        ]);
    }

    // 詳細ページ表示
    public function showDetailPage($id) {
        $company_list = $this->getCompanylist();
        $product_detail = $this->getProductDetail($id);

        return view('test_detail',compact('id')) -> with ([
            'company_list' => $company_list,
            'product_detail' => $product_detail
        ]);
    }

    // 編集ページ表示
    public function showEditPage($id) {
        $company_list = $this->getCompanylist();
        $product_detail = $this->getProductDetail($id);

        return view('test_edit',compact('id')) -> with ([
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

    ////////////////////////////
    // 商品詳細取得(使いまわし) //
    ////////////////////////////
    public function getProductDetail($id) {
        $hoge = new TestProducts();
        $data = $hoge -> getProductDetailDB($id);
        return $data;
    }

    ////////////////////////////
    // 商品情報取得(使いまわし) //
    ////////////////////////////
    public function getProductData($id) {
        $hoge = new TestProducts();
        $data = $hoge -> getProductDataDB($id);
        return $data;
    }

    ///////////////
    //  在庫減少  //
    ///////////////
    public function decreaseStock($id) {
        DB::beginTransaction();
        try {
            $hoge = new TestProducts();
            $hoge -> decrementStockDB($id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
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
            $hoge1 = new TestProducts();
            $hoge2 = app()->make('App\Http\Controllers\TestSaleController');

            //ファイルアップロードされた場合、対象画像のパスをdbに格納
            //アップロード無しの場合、特定画像のパスをdbに格納
            if (isset($file)) {
                $file_name = $file->getClientOriginalName();
                $file->storeAs('', $file_name);

                $file_name = 'http://localhost/step8task/storage/app/'.$file_name;

                DB::beginTransaction();
                try {
                    $id = $hoge1 -> insertProductListDB($request, $file_name);
                    $hoge2 -> insertSale($id);

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            } else {
                DB::beginTransaction();
                try {
                    $id = $hoge1 -> insertProductListDB($request, "http://localhost/step8task/storage/app/noimage.png");
                    $hoge2 -> insertSale($id);

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }
            
            // configフォルダのmassage.phpからフラッシュメッセージデータを取得
            $msg = Config::get('message.$flashmsg.successAddData');

            return redirect()->route('admin.addpage.show')
            ->with('successMessage', $msg);
        }
    }

    /////////////////////////////////
    // 商品編集の更新を押した時の処理 //
    /////////////////////////////////
    public function editProduct(Request $request) {
        $aaa = app()->make('App\Http\Controllers\TestValidateController');
        $validator = $aaa->validateEditProduct($request);

        $id = $request->id;
        $hoge = new TestProducts();

        // メーカーリスト取得
        $company_list = $this->getCompanylist();
        
        if ($validator->fails()) {
        //バリデーションエラー有り
            return redirect()->route('admin.edit',compact('id'))
            ->withErrors($validator)
            ->withInput();
        } else {
        //バリデーションエラー有り
            $file = $request->file('imgFeditimage');
            //$pdata = $hoge->getProductDataDB($request->txtFeditproductid);
            $pdata = $this->getProductData($request->txtFeditproductid);

            //ファイルアップロードされた場合、storage\appに画像を保存
            if (isset($file)) {
                $file_name = $file->getClientOriginalName();
                $file->storeAs('', $file_name);

                $file_name = 'http://localhost/step8task/storage/app/'.$file_name;
                
                DB::beginTransaction();
                try {
                    $hoge -> editProductDB($request, $file_name);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            } else {
                DB::beginTransaction();
                try {
                    $hoge -> editProductDB($request, $pdata->img_path);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }

            // configフォルダのmassage.phpからフラッシュメッセージデータを取得
            $msg = Config::get('message.$flashmsg.successEditData');

            return redirect()->route('admin.edit',compact('id'))->with([
                'successMessage' => $msg,
            ]);
        }
    }

    /////////////////////////////
    //     データ検索(Ajax)     //
    /////////////////////////////
    public function searchAjax(Request $request) {
        $hoge = new TestProducts();
        //モデルに入力されたデータ渡して検索してもらう
        $product_list = $hoge->getProductListDB($request->pname,$request->cname,$request->priceH,$request->priceL,$request->stockH,$request->stockL);
        
        $data = [
            'pname' => $product_list,
        ];
        return response()->json($data);
    }

    /////////////////////////////
    //     データ削除(Ajax)     //
    /////////////////////////////
    public function deleteProductAjax(Request $request) {
        $hoge1 = new TestProducts();
        DB::beginTransaction();
        try {
            $hoge1 -> deteleProductDB($request->id);
            $hoge2 = app()->make('App\Http\Controllers\TestSaleController');
            $hoge2 -> deteleSale($request->id);

            DB::commit();
            return response()->json();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
