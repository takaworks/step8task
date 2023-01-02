<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\TestSale;
use Illuminate\Support\Facades\DB;

class TestSaleController extends Controller
{
    public function insertSale($id){
        $hoge = new TestSale();
        
        DB::beginTransaction();
        try {
            $hoge -> insertSaleDB($id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function deteleSale($id){
        $hoge = new TestSale();

        DB::beginTransaction();
        try {
            $hoge -> deleteSaleDB($id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

}
