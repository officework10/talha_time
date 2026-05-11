<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('getDatabaseData')) {
    function getDatabaseData() {
        $allcategories = DB::table('categories')->select('cat_name','is_del', 'img', 'cat_time','cat_id')->where('is_del', 0)->get();
        return $allcategories;
    }
}

