<?php

use Illuminate\Support\Facades\Route;

// ====frontend==========
require __DIR__.'/public.php';

// =======backend=======
Route::prefix('admin')->group(function(){
    require __DIR__.'/admin.php';
});
