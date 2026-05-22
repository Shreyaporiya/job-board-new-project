<?php

use Illuminate\Support\Facades\Route;

Route::get('/table', function () {
    return view('table_content');
})->name('simple-tables');

Route::get('/general-form', function () {
    return view('form_content');
})->name('general-form');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('admin-dashboard');

Route::get('/tables-sidebar', function () {
    return view('partials.tables.table_sidebar');
})->name('table-sidebar');

Route::get('/', function () {
    return view('welcome');
});
