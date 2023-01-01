<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\TestProducts;
use Illuminate\Support\Facades\DB;

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

        $hoge = new TestProducts();
        $product_detail = $hoge->getProductDetailDB($id);

        return view('test_detail',compact('id')) -> with ([
            'company_list' => $company_list,
            'product_detail' => $product_detail
        ]);
    }

    // 編集ページ表示
    public function showEditPage($id) {
        $company_list = $this->getCompanylist();

        $hoge = new TestProducts();
        $product_detail = $hoge->getProductDetailDB($id);

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

                $file_name = 'http://localhost/step8task/storage/app/'.$file_name;

                DB::beginTransaction();
                try {
                    $hoge -> insertProductListDB($request, $file_name);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            } else {
                DB::beginTransaction();
                try {
                    $hoge -> insertProductListDB($request, "http://localhost/step8task/storage/app/noimage.png");
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }
            
            return redirect()->route('admin.addpage.show')
            ->with('successMessage','データを追加しました。');
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
        $product_detail = $hoge->getProductDetailDB($id);
        
        if ($validator->fails()) {
        //バリデーションエラー有り
            return redirect()->route('admin.edit',compact('id'))
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
                    $hoge -> editProductDB($request, $img_path->img_path);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }

            return redirect()->route('admin.edit',compact('id'))->with([
                'successMessage'=>'データを更新しました。',
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
    public function deleteAjax(Request $request) {
        $hoge = new TestProducts();
        DB::beginTransaction();
        try {
            $hoge -> deteleDB($request->id);
            DB::commit();
            return response()->json();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
