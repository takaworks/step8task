<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TestSale extends Model
{
    protected $table = 'testsale';
    protected $dates =  ['created_at', 'updated_at'];
    protected $fillable = ['id'];


    ////////////////////////////////////
    // testsaleテーブルにデータを挿入 //
    ////////////////////////////////////
    public function insertSaleDB($id) {
        DB::table('testsale')->insert([
            'product_id' => $id,
            'by_count' => 0,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
    }

    ///////////////////////////
    // testsaleのデータを削除 //
    ///////////////////////////
    public function deleteSaleDB($id) {
        DB::table('testsale')
        ->where('testsale.product_id', $id)
        ->delete();
    }

    /////////////////////////
    // testsaleの購入数増加 //
    /////////////////////////
    public function incrementBuyCountDB($id) {
        DB::table('testsale')
        ->where('testsale.product_id', $id)
        ->increment('buy_count');
    }

    ////////////////////////////////
    //  DBから指定IDのデータを取得  //
    ////////////////////////////////
    public function getSaleDataDB($id) {
        $data = DB::table('testsale')
        ->where('testsale.product_id', $id)
        ->first();
        
        return $data;
    }

    //////////////////////////////
    // 指定IDのデータがあるか確認 //
    //////////////////////////////
    public function checkDataExistDB($id) {
        if(DB::table('testsale')->where('testsale.product_id', $id)->exists()){
            $flag = true;
        } else {
            $flag = false;
        }
        return $flag;
    }
}
