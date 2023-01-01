const detailurl = "http://localhost/step8task/public/home/detail/";
const homeurl = "http://localhost/step8task/public/home";
const regex = /[^0-9]/g;

// ページ読み込み時に実行したい処理
window.onload = function(){
    var url = location.href

    if(url == homeurl){
        //ページ読み込み時商品一覧取得するため、検索イベントを強制発火
        document.querySelector("#search_product").click();
    }
}

// ajax全て完了後に行う。(空のデーブルだとtablesorterが上手く機能しないため)
$(document).ajaxComplete(function() {
    $("#ptable").tablesorter();

    deleteData();
});

// 通信に関連する設定のデフォルト値
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$("#ptable").tablesorter({
    headers: {
        1: {sorter:false},
        2: {sorter:false},
        6: {sorter:false},
        7: {sorter:false},
    }
});

/////////////////////////////////////
// 一覧表示にて検索ボタンを押された時 //
/////////////////////////////////////
$("#search_product").on("click", function() {
    let pname =$("#txtFproduct").val(); // 商品名
    let cname =$("#drpFcompany").val(); // メーカー名
    let priceH =$("#txtFpriceH").val(); // 価格上限
    let priceL =$("#txtFpriceL").val(); // 価格下限
    let stockH =$("#txtFstockH").val(); // 在庫上限
    let stockL =$("#txtFstockL").val(); // 在庫下限

    $.ajax({
        type: 'POST',
        url: '/step8task/public/home/ajaxsearch',   //route
        data: {
            'pname': pname,                          //コントローラに渡すパラメータ
            'cname': cname,
            'priceH': priceH,
            'priceL': priceL,
            'stockH': stockH,
            'stockL': stockL,
        },
        dataType: 'json',
        timeout: 3000
    }).done(function(data){
        // $.each(data.pname[0],function(index,value){
        //     console.log(index + ':' + value);
        // })
        
        // 一度ヘッダー以外削除
        $('#ptable').find('td').remove();

        // tbodyを一撃で書き換えるためstrに設定
        let str;
        for(let i = 0; i < data.pname.length; i++) {
            str += "<tr>";
                str += "<td>";
                str += data.pname[i].id;
                str += "</td>";

                str += "<td>";
                str += "<img src=" + data.pname[i].img_path + ">";
                str += "</td>";

                str += "<td>";
                str += data.pname[i].product_name;
                str += "</td>";

                str += "<td>";
                str += data.pname[i].price;
                str += "</td>";

                str += "<td>";
                str += data.pname[i].stock;
                str += "</td>";

                str += "<td>";
                str += data.pname[i].company_name;
                str += "</td>";

                str += "<td>";
                str += "<button onclick=\"location.href=\'" + detailurl + data.pname[i].id + "\'\" type=\"button\" name=\"btnFdetail\">詳細</button>";
                str += "</td>";

                str += "<td>";
                str += "<button type=\'button\' class=\"Base__color--alart btnFdeleteproduct\" id=\"btnFdeleteproduct" + data.pname[i].id + "\">削除";
                str += "</td>";
            str += "</tr>";
        }
        // strを実際にHTMLへ反映
        $("#ptable").append(str);

        //行を追加削除した後にtablesorter更新(これ行わないとtablesorter機能しない)
        $("#ptable").trigger("update");

    }).fail(function(){
        alert("通信に失敗しました");
    });
});

/////////////////////////
//    商品データ削除    //
/////////////////////////
function deleteData(){
    $(".btnFdeleteproduct").on("click", function() {
        if( confirm("本当に削除しますか？") ) {
            // 押されたボタンのID名を取得
            let str = $(this).attr('id');
            // 取得したID名から数字だけ取得
            let id = str.replace(regex,"");

            $.ajax({
                type: 'POST',
                url: '/step8task/public/home/' + id,   // route
                data: {
                    'id' : id,
                    '_method': 'DELETE',
                },
                dataType: 'json',
                timeout: 3000,
                context: this,                          //これによりコールバック関数でも$thisが使えるようになる
            }).done(function(data){
                console.log(id);

                //押下されたボタンの行を削除(表示上)
                $(this).closest("tr").remove();
            }).fail(function(){
                alert("通信に失敗しました");
            });

        } else {
            return false;
        }
    });
}