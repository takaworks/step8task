
@extends('layouts.app')

@section('title', '商品一覧')

@section('content')
        <header>
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth

                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            <!-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form> -->
        </header>

        <main>
            <div class="Home">
                <h2>商品検索</h2>
                <form action="{{ url('/home') }}" method="post">
                    {{ csrf_field() }}
                    <ul>
                        <li>
                            商品名<br>
                            <input type="text" class="Home__size--input" name="txtFproduct">
                        </li>

                        <li>
                            企業名<br>
                            <select class="Home__size--input" name="drpFcompany">
                                <option></option>
                                @foreach ($companylist as $val1)
                                    <option>{{$val1->company_name}}</option>
                                @endforeach
                            </select>
                        </li>

                        <li>
                            <button type="submit" class="Home__size--input">検索</button>
                        </li>
                    </ul>
                </form> 
            </div>

            <div class="Home">
                <h2>商品一覧</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>画像</th>
                            <th>商品名</th>
                            <th>価格</th>
                            <th>在庫数</th>
                            <th>メーカー名</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productlist as $val)
                        <tr>
                            <td>{{$val->id}}</td>
                            <td><img src="{{$val->img_path}}"></td>
                            <td>{{$val->product_name}}</td>
                            <td>{{$val->price}}</td>
                            <td>{{$val->stock}}</td>
                            <td>{{$val->company_name}}</td>
                            <td>
                                <button type="button" name="btnFdetail">詳細表示</button>
                            </td>
                            <td>
                                <form action="home/" method="post" onsubmit="deleteAlert()">
                                    {{ csrf_field() }}
                                    <input type='submit' value="削除" class="Home__color--alart" name="btnFdeleteproduct">
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
                <button id="btn" type="button" class="Home__size--full" name="btnFaddproduct">商品追加</button>

            
        </main>
    </body>
    @endsection
