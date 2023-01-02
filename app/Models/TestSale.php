<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TestSale extends Model
{
    ////////////////////////////////////
    // test_salesテーブルにデータを挿入 //
    ////////////////////////////////////
    public function insertSaleDB($id) {
        DB::table('test_sales')->insert([
            'product_id' => $id,
            'by_count' => 0,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
    }

    /////////////////////////////
    // test_salesのデータを削除 //
    /////////////////////////////
    public function deleteSaleDB($id) {
        DB::table('test_sales')
        ->where('test_sales.product_id', $id)
        ->delete();
    }
}
