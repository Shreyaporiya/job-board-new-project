<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;

Route::middleware(['auth'])->group(function () {

    Route::get(
        '/subscriptions',
        [SubscriptionController::class, 'index']
    );

    Route::get(
        '/checkout/{priceId}',
        [SubscriptionController::class, 'checkout']
    );

    Route::get(
        '/subscription-success',
        [SubscriptionController::class, 'success']
    )->name('subscription.success');

    Route::get(
        '/cancel-subscription',
        [SubscriptionController::class, 'cancel']
    )->name('subscription.cancel');
});

Route::post('/checkout', [StripeController::class, 'checkout'])
    ->name('checkout');

Route::get('/success', [StripeController::class, 'success'])
    ->name('success');

Route::get('/cancel', [StripeController::class, 'cancel'])
    ->name('cancel');

Route::get('/payments', function () {

    $payments = \App\Models\Payment::latest()->get();

    return view('payments', compact('payments'));

});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

require __DIR__ . '/auth.php';