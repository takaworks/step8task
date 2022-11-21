<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ZZZ extends Model
{
    public function getZZZ() {
        // articlesテーブルからデータを取得
        $Z = DB::table('test_users')->get();

        return $Z;
    }
}
