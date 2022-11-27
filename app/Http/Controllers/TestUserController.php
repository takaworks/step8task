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
        $model = new TestUser();
        $data = $model->getProductList();

        return view('home', ['data' => $data]);
    }
}
