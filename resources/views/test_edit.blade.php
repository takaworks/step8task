
@extends('layouts.app')

@section('title', '商品情報編集')

@section('content')
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

            <!-- フラッシュメッセージ -->
            @if(session()->has('successMessage'))
                <div class="alert alert-success">
                    {{ session('successMessage') }}
                </div>
            @endif

            <div class="Base">
                <h2>商品情報編集</h2>
                    <ul>
                        @foreach ($product_detail as $val)
                            <form action="{{ route('admin.edit', $id) }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                            <li>
                                商品情報ID<br>
                                <input type="text" class="Base__size--input" name="txtFeditproductid" value={{$id}} readonly>
                            </li>

                            <li>
                                商品名<br>
                                <input type="text" class="Base__size--input" name="txtFeditproduct" value={{ $val->product_name }}>
                            </li>

                            <li>
                                メーカー名<br>
                                <select class="Base__size--input" name="drpFeditcompany" >
                                    @foreach ($company_list as $comp)
                                        <option value={{ $comp->id }}
                                            @if($comp->id===$val->company_id) selected @endif>
                                            {{ $comp->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </li>

                            <li>
                                価格<br>
                                <input type="text" class="Base__size--input" name="txtFeditprice" value={{ $val->price }}>
                            </li>

                            <li>
                                在庫数<br>
                                <input type="text" class="Base__size--input" name="txtFeditstock" value={{ $val->stock }}>
                            </li>

                            <li>
                                コメント<br>
                                <textarea class="Base__size--input" rows="3" cols="40" name="txtFeditcomment">{{ $val->comment }}</textarea>
                            </li>

                            <li>
                                商品画像<br>
                                <input type="file" name="imgFeditimage" accept="image/png, image/jpeg"><br><br>
                                <img src="{{ $val->img_path }}">
                            </li>

                            <li>
                                <button type="submit" class="Base__size--input">更新</button>
                            </li>
                        </form> 
                        @endforeach
                    </ul>
            </div>

            <div>
                <button onclick="location.href='{{ route('admin.detail', $id) }}'"  type="button" class="Base__size--full" name="btnFbackindex">戻る</button>
            </div>
        </main>
    </body>
    @endsection
