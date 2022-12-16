function deleteAlert() {
    if( confirm("本当に削除しますか？") ) {
        alert('削除しました。');
        document.deleteform.submit();
    } else {
        //alert('キャンセルしました。');
        return false;
    }
};
