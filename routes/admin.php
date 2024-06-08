<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/home',[HomeController::class,'index'])->name('admin.home');

Route::resources([
    'category'=>CategoryController::class,
    'tag'=>TagController::class,
]); 