
@extends('layouts.app')

@section('title', '商品一覧')

@section('content')
    <main>
        <div class="Base">
            <h2>商品検索</h2>
            <ul>
                <li>
                    商品名<br>
                    <input type="text" id="txtFproduct" class="Base__size--input">
                </li>

                <li>
                    メーカー名<br>
                    <select class="Base__size--input" id="drpFcompany" >
                            <option></option>
                            @foreach ($company_list as $val1)
                                <option>{{ $val1->company_name }}</option>
                            @endforeach
                        </select>
                </li>

                <li>
                    価格<br>
                    <input type="text" id="txtFpriceH" class="Base__size--inputright">円 ～ 
                    <input type="text" id="txtFpriceL" value ="0" class="Base__size--inputright">円
                </li>

                <li>
                    在庫数<br>
                    <input type="text" id="txtFstockH" class="Base__size--inputright"> ～ 
                    <input type="text" id="txtFstockL" value ="0" class="Base__size--inputright">
                </li>

                <li>
                    <button type="button" class="Base__size--input" id="search_productjjj">検索</button>
                </li>
            </ul>
        </div>

        <div class="Base">
            <h2>商品一覧</h2>
            <table id="ptable">
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

                </tbody>
            </table>
        </div>
        
        <div>
            <button onclick="location.href='home/add'"  type="button" class="Base__size--full" name="btnFaddproduct" >商品追加</button>
        </div>
        
    </main>
</body>
@endsection
