<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('test');
});

Route::get('/sidebar-demo', function () {
    return view('sidebar-demo');
});
