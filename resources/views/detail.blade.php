
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

                    @foreach ($product_detail as $val)
                    <tbody>
                        <tr>
                            <td>商品情報ID</td>
                            <td>{{$id}}</td>
                        </tr>
                        <tr>
                            <td>商品画像</td>
                            <td><img src="{{ $val->img_path }}"></td>
                        </tr>
                        <tr>
                            <td>商品名</td>
                            <td>{{ $val->product_name }}</td>
                        </tr>
                        <tr>
                            <td>メーカー名</td>
                            <td>{{ $val->company_name}}</td>
                        </tr>
                        <tr>
                            <td>価格</td>
                            <td>{{ $val->price }}円</td>
                        </tr>
                        <tr>
                            <td>在庫数</td>
                            <td>{{ $val->stock }}</td>
                        </tr>
                        <tr>
                            <td>コメント</td>
                            <td>{{ $val->comment }}</td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
            
            <div>
                <button onclick="location.href='{{ route('admin.index.show') }}'"  type="button" class="Base__size--full" name="btnFbackindex">戻る</button>
            </div>
            
        </main>
    </body>
    @endsection
