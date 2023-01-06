<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\TestSale;
use Illuminate\Support\Facades\DB;

class TestSaleController extends Controller
{
    public function insertSale($id) {
        $hoge = new TestSale();

        DB::beginTransaction();
        try {
            $hoge -> insertSaleDB($id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function deteleSale($id) {
        $hoge = new TestSale();

        DB::beginTransaction();
        try {
            $hoge -> deleteSaleDB($id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    /////////////////////////////////////////////////////////////////////////////////
    //  APIからのルーティング                                                        //
    //  id情報を受け取って、saleテーブルに購入回数を加算、productsテーブルから在庫を減産 //
    /////////////////////////////////////////////////////////////////////////////////
    public function count(Request $request) {
        $hoge = new TestSale();
        $aaa = app()->make('App\Http\Controllers\TestProductsController');
        $existflag = $hoge->checkDataExistDB($request->id);

        //その購入する商品データが存在するか確認
        if($existflag) {
            $pdata = $aaa->getProductData($request->id);        // 減算前の在庫本数取得
            $previous_stock = $pdata->stock;

            $buydata = $hoge->getSaleDataDB($request->id);      // 加算前の累計購入本数を取得
            $previous_buycount = $buydata->buy_count;

            //在庫ストック数がまだあるなら以下の処理
            if($previous_stock > 0) {
                $aaa->decreaseStock($request->id);              // 在庫本数を1減算

                $pdata = $aaa->getProductData($request->id);    // 減算後の在庫本数取得
                $current_stock = $pdata->stock;

                //testproductsテーブルのストック数をちゃんと減算できたらtestsaleテーブルの購入数を1つ増やす
                if($previous_stock <> $current_stock) {
                    DB::beginTransaction();
                    try {
                        $hoge->incrementBuyCountDB($request->id);   // 累計購入本数を1加算
                        DB::commit();

                        $buydata = $hoge->getSaleDataDB($request->id);  // 購入完了後、累計購入本数を取得
                        $current_buycount = $buydata->buy_count;

                        $str = "商品ID : " . $request->id . "\n";
                        $str .= "商品名 : " . $pdata->product_name . "\n";
                        $str .= "ストック数 : " . $previous_stock . " -> " . $current_stock . "\n";
                        $str .= "累計購入本数 : " . $previous_buycount . " -> " . $current_buycount;
                        
                        return $str;
                    } catch (\Exception $e) {
                        DB::rollBack();
                    }
                } else {
                    return "DB処理エラー";
                }
            } else {
                return "在庫なし";
            }
        } else {
            return "その商品は購入できません。(対応ID無し)";
        }

    }

}
