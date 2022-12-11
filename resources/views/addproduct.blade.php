
@extends('layouts.app')

@section('title', '商品一覧')

@section('content')
        <header>
            <!-- @if (Route::has('login'))
                <div class="top-right links">
                    @auth

                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif -->
            <!-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form> -->
        </header>

        <main>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="Home">
                <h2>商品検索</h2>
                <form action="{{ url('/home/add_product') }}" method="post">
                    {{ csrf_field() }}
                    <ul>
                        <li>
                            商品名<br>
                            <input type="text" class="Home__size--input" name="txtFaddproduct" value="{{old('txtFaddproduct')}}">
                        </li>

                        <li>
                            メーカー名<br>
                            <select class="Home__size--input" name="drpFaddcompany" >
                                <option></option>
                                @foreach ($companylist as $val1)
                                    <option>{{$val1->company_name}}</option>
                                @endforeach
                            </select>
                        </li>

                        <li>
                            価格<br>
                            <input type="text" class="Home__size--input" name="txtFaddcost" value="{{old('txtFaddcost')}}">
                        </li>

                        <li>
                            在庫数<br>
                            <input type="text" class="Home__size--input" name="txtFaddstock" value="{{old('txtFaddstock')}}">
                        </li>

                        <li>
                            コメント<br>
                            <textarea class="Home__size--input" rows="3" cols="40" name="txtFaddcomment"></textarea>
                        </li>

                        <li>
                            商品画像<br>
                            <input type="file" name="imgFaddimage" accept="image/png, image/jpeg">
                        </li>

                        <li>
                            <button type="submit">追加</button>
                        </li>
                    </ul>
                </form> 
            </div>

            <button onclick="location.href='/step7task/public/home/'"  type="button" class="Home__size--full" name="btnFaddproduct">戻る</button>
        </main>
    </body>
    @endsection
