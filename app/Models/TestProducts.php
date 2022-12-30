<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TestProducts extends Model
{
    /////////////////////////////////////////////////////////////////
    // testproductsテーブルから検索データをもとにデータ取得(部分一致) //
    /////////////////////////////////////////////////////////////////
    public function searchProductListDB($product_name,$company_name) {
        // productsテーブルとcompaniesを連結
        // productsのcompany_idをcompaniesのcompany_nameとする
        $data = DB::table('testproducts')
        ->select('testproducts.id',
                'testproducts.img_path',
                'testproducts.product_name',
                'testproducts.price',
                'testproducts.stock',
                'test_companies.company_name as company_name')
        ->where('testproducts.product_name', 'LIKE', '%'. $product_name .'%')
        ->where('company_name', 'LIKE', '%'. $company_name .'%')
        ->join('test_companies','testproducts.company_id','=','test_companies.id')
        ->get();

        return $data;
    }

    //////////////////////////////////////////
    // test_companiesテーブルからデータを取得 //
    //////////////////////////////////////////
    public function getCompanyListDB() {
        $data = DB::table('test_companies')->get();
        return $data;
    }

    /////////////////////////////////////
    // 詳細ボタンから必要情報のデータ取得 //
    /////////////////////////////////////
    public function getProductDetailDB($id) {
        $data = DB::table('testproducts')
        ->where('testproducts.id', $id)
        ->join('test_companies','testproducts.company_id','=','test_companies.id')
        ->get();

        return $data;
    }

    ////////////////////////////////////////
    // test_companiesテーブルにデータを挿入 //
    ////////////////////////////////////////
    public function insertProductListDB($data,$filename) {
        DB::table('testproducts')->insert([
            'company_id' => $data->drpFaddcompany,
            'product_name' => $data->txtFaddproduct,
            'price' => $data->txtFaddprice,
            'stock' => $data->txtFaddstock,
            'comment' => $data->txtFaddcomment,
            'img_path' => $filename,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
    }

    ////////////////////////////////////////
    // test_companiesテーブルのデータを更新 //
    ////////////////////////////////////////
    public function editProductDB($data,$filename) {
        DB::table('testproducts')
        ->where('testproducts.id', $data->txtFeditproductid)
        ->update([
            'company_id' => $data->drpFeditcompany,
            'product_name' => $data->txtFeditproduct,
            'price' => $data->txtFeditprice,
            'stock' => $data->txtFeditstock,
            'comment' => $data->txtFeditcomment,
            'img_path' => $filename,
            'updated_at' => NOW(),
        ]);
    }

    ///////////////////////////////////////
    //  DBから今登録されている画像URL取得  //
    ///////////////////////////////////////
    public function getimgDB($id) {
        $data = DB::table('testproducts')
        ->where('testproducts.id', $id)
        ->first();
        
        return $data;
    }

    //////////////////////////////
    //  DBから指定のデータを削除  //
    //////////////////////////////
    public function deteleDB($id) {
        $data = DB::table('testproducts')
        ->where('testproducts.id', $id)
        ->delete();
    }

    //////////////////////////////////
    // テーブルのデータを検索(Ajax用) //
    //////////////////////////////////
    public function getProductDetailDBAjax($pname,$cname,$priceH,$priceL,$stockH,$stockL){

        if ($priceH=="") {
            $priceH=1000;
        }
        if ($priceL=="") {
            $priceL=0;
        }
        if ($stockH=="") {
            $stockH=1000;
        }
        if ($stockL=="") {
            $stockL=0;
        }

        $data = DB::table('testproducts')
        ->select('testproducts.id',
                'testproducts.img_path',
                'testproducts.product_name',
                'testproducts.price',
                'testproducts.stock',
                'test_companies.company_name as company_name')
        ->where('testproducts.product_name', 'LIKE', '%'. $pname .'%')
        ->where('company_name', 'LIKE', '%'. $cname .'%')
        ->wherebetween('price',[$priceL,$priceH])
        ->wherebetween('stock',[$stockL,$stockH])
        ->join('test_companies','testproducts.company_id','=','test_companies.id')
        ->get();

        return $data;
    }
}
