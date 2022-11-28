<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\TestUser;

class TestUserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // インスタンス生成
        $hoge1 = new TestUser();
        $hoge2 = new TestUser();
        $productlist = $hoge1->getProductList();
        $companylist = $hoge2->getCompanyList();

        return view('home', ['productlist' => $productlist], ['companylist' => $companylist]);
    }
}
