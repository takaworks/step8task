
@extends('layouts.app')

@section('title', '商品一覧')

@section('content')
    <main>
        <div class="Base">
            <h2>商品検索</h2>
            <form action="{{ url('/home') }}" method="post">
                {{ csrf_field() }}
                <ul>
                    <li>
                        商品名<br>
                        <input type="text" class="Base__size--input" name="txtFproduct">
                    </li>

                    <li>
                        メーカー名<br>
                        <select class="Base__size--input" name="drpFcompany">
                            <option></option>
                            @foreach ($company_list as $val1)
                                <option>{{ $val1->company_name }}</option>
                            @endforeach
                        </select>
                    </li>

                    <li>
                        <button type="submit" class="Base__size--input">検索</button>
                    </li>
                </ul>
            </form> 
        </div>

        <div class="Base">
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
                    @foreach ($product_list as $val)
                    <tr>
                        <td>{{ $val->id }}</td>
                        <td><img src="{{ $val->img_path }}"></td>
                        <td>{{ $val->product_name }}</td>
                        <td>{{ $val->price }}円</td>
                        <td>{{ $val->stock }}</td>
                        <td>{{ $val->company_name }}</td>
                        <td>
                            <button onclick="location.href='{{ route('admin.detail', $val->id) }}'"  type="button" name="btnFdetail">詳細</button>
                        </td>
                        <td>
                            <form action="{{ route('admin.delete', $val->id) }}" method="post" onsubmit="deleteAlert();return false;">
                                {{ csrf_field() }}
                                @method('delete')
                                <input type='submit' value="削除" class="Base__color--alart" name="btnFdeleteproduct">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div>
            <button onclick="location.href='home/add'"  type="button" class="Base__size--full" name="btnFaddproduct" >商品追加</button>
        </div>
        
    </main>
</body>
@endsection
