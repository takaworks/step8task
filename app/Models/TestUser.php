<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class TestUser extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // test_productsテーブルからデータを取得
    public function getProductList() {
        // productsテーブルとcompaniesを連結
        // productsのcompany_idをcompaniesのcompany_nameとする
        $hoge = DB::table('test_products')
        ->select('test_products.id',
                'test_products.img_path',
                'test_products.product_name',
                'test_products.price',
                'test_products.stock',
                'test_companies.company_name as company_name')

        ->join('test_companies','test_products.company_id','=','test_companies.id')
        ->get();

        return $hoge;
    }

}