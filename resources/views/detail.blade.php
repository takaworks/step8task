
@extends('layouts.app')

@section('title', '商品詳細')

@section('content')
        <main>
            <div class="Base">
                <h2>商品詳細</h2>
                <table>
                    <thead>
                        <tr>
                            <th>項目</th>
                            <th>詳細</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>商品情報ID</td>
                            <td>{{$id}}</td>
                        </tr>
                        <tr>
                            <td>商品画像</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>商品名</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>メーカー名</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>価格</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>在庫数</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>コメント</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div>
                <button onclick="location.href='{{ route('admin.index.show') }}'"  type="button" class="Base__size--full" name="btnFbackindex">戻る</button>
            </div>
            
        </main>
    </body>
    @endsection
