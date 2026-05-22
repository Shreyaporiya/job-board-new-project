<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LibrarianController;
use App\Http\Controllers\MemberController;

// TEST: Simple route without middleware first
Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
Route::get('/librarian/dashboard', [LibrarianController::class, 'dashboard']);
Route::get('/member/dashboard', [MemberController::class, 'index']);

// TEST: Route with only auth middleware
//Route::get('/admin/test-auth', [AdminController::class, 'dashboard'])->middleware('auth');

// TEST: Route with both middlewares
Route::get('/admin/test-admin', [AdminController::class, 'dashboard'])->middleware(['auth', 'admin']);
// Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);


    // Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    //     Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // });

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
