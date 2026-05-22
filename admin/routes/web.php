<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('general-form', function(){
    return view('admin.forms.general');
})->name('general-form');

Route::get('charts', function(){
    return view('admin.charts.chartjs');
})->name('chartjs');

Route::get('Tables', function(){
    return view('admin.table.simple');
})->name('simple-table');

Route::get('admin-dashboard', function(){
    return view('admin.layouts.app');
})->name('admin-page');

Route::get('/admin-test', function() {
    return view('admin.index');
});

