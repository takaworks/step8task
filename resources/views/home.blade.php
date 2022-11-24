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
        </header>

        <main>
            <div class="show1">
                <form action="" method="post">
                    <h2>商品検索</h2>
                    <ul>
                        <li>
                            商品名<br>
                            <input type="text" class="inputsize" name="product_name_input">
                        </li>

                        <li>
                            企業名<br>
                            <select class="inputsize" name="company_name_input">
                                <option hidden>-- 選択してください --</option>
                            </select>
                        </li>

                        <li>
                            <button type="button" class="inputsize" name="btn_add_product">検索</button>
                        </li>
                    </ul>
                </form> 
            </div>

            <div class="show1">
                <h2>検索結果</h2>
                <ul>
                    <div class="flexbox">
                        <div class="boxA">
                            <li>
                                <img src="https://dummyimage.com/400x400/000/fff" alt="商品画像" class="iamge">
                            </li>
                        </div>

                        <div class="boxB">
                            <li class="input_table">
                                id<br>
                                <input type="text" class="inputsize" name="product_id_output">
                            </li>

                            <li class="input_table">
                                商品名<br>
                                <input type="text" class="inputsize" name="product_name_output">
                            </li>

                            <li class="input_table">
                                価格<br>
                                <input type="text" class="inputsize" name="product_price_output">
                            </li>

                            <li class="input_table">
                                在庫数<br>
                                <input type="text" class="inputsize" name="product_stock_output">
                            </li>

                            <li class="input_table">
                                商品名<br>
                                <input type="text" class="inputsize" name="company_name_output">
                            </li>

                            <li class="input_table">
                                <button type="button" class="inputsize" name="btn_show_detail">詳細表示</button><br>
                            </li>

                            <li class="input_table">
                                <button type="button" class="inputsize alart_cfg" name="btn_delete">削除</button>
                            </li>
                        </div>
                    </div>
                </ul>
            </div>

            <div>
                <button type="button" class="show2" name="btn_add_product">商品追加</button>
            </div>
        </main>

    </body>
</html>