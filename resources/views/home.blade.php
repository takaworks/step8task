<!DOCTYPE html> 
<html lang="ja">  
    <head>
        <meta charset="UTF-8"> 
        <title>商品情報一覧</title>
        <link href="{{ asset('/css/home.css') }}" rel="stylesheet" >
    </head> 

    <body>
        <header>
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                ログアウト
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
            </form>
        </header>

        <main>
            <div class="show1">
                <form action="home.blade.php" method="post">
                    <h2>商品検索</h2>
                    <ul>
                        <li>
                            商品名<br>
                            <input type="text" class="inputsize" name="input_product_name">
                        </li>

                        <li>
                            企業名<br>
                            <select class="inputsize" name="input_company_name">
                                <option hidden>-- 選択してください --</option>
                                @foreach ($data as $val)
                                    <option>{{$val->company_name}}</option>
                                @endforeach
                            </select>
                        </li>

                        <li>
                            <button type="submit" class="inputsize" name="btn_search_product">検索</button>
                        </li>
                    </ul>
                </form> 
            </div>

            <div class="show1">
                <h2>商品一覧</h2>
                <table class="show3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>イメージパス</th>
                            <th>商品名</th>
                            <th>価格</th>
                            <th>在庫数</th>
                            <th>メーカー名</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $val)
                        <tr>
                            <td>{{$val->id}}</td>
                            <td><img src="{{$val->img_path}}"></td>
                            <td>{{$val->product_name}}</td>
                            <td>{{$val->price}}</td>
                            <td>{{$val->stock}}</td>
                            <td>{{$val->company_name}}</td>
                            <td>
                                <button type="button" class="" name="btn_show_detail">詳細表示</button>
                            </td>
                            <td>
                                <button type="button" class="alart_cfg" name="btn_detele_productdata">削除</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div>
                <button type="button" class="show2" name="btn_add_product">商品追加</button>
            </div>

        </main>
    </body>
</html>
