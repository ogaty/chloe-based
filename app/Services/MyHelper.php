<?php

namespace App\Services;

use Session;

class MyHelper
{
    public static function postRoute() {
        if (Route::is('admin.post.index') || Route::is('admin.post.create') || Route::is('admin.post.edit')) {
            return true;
        }
        return false;
    }
}
