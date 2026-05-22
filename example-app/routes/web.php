<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\UserCacheController;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\LogController;
use App\Http\Controllers\FileDownloadController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HttpClientController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SmsController;
use Illuminate\Support\Facades\Process;
use App\Jobs\SendWelcomeEmail;
use Illuminate\Support\Facades\Bus;
use App\Jobs\StepOneJob;
use App\Jobs\StepTwoJob;
use App\Jobs\StepThreeJob;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Select2Controller;

Route::get('/ajax/states/{country_id}', [LocationController::class, 'getStates']);
Route::get('/ajax/cities/{state_id}', [LocationController::class, 'getCities']);

Route::get('/multi-select', [LocationController::class, 'create']);
Route::post('/profile/store', [LocationController::class, 'store']);


// Route::get('/select2-static', [Select2Controller::class, 'index']);
// Route::post('/select2-static', [Select2Controller::class, 'store'])->name('select2.static.store');




Route::get('/location-form', [LocationController::class, 'index']);

Route::get('/get-states/{country}', [LocationController::class, 'getStates']);
Route::get('/get-cities/{state}', [LocationController::class, 'getCities']);


Route::get('/send-reminders', [SubscriptionController::class, 'sendReminders']);

Route::middleware(['auth'])->group(function () {

    // USERS LIST PAGE
    Route::get('/users', [FriendRequestController::class, 'users'])
        ->name('users.list');

    // REQUEST PAGES
    Route::get('/requests/incoming', [FriendRequestController::class, 'incoming'])
        ->name('requests.incoming');

    Route::get('/requests/outgoing', [FriendRequestController::class, 'outgoing'])
        ->name('requests.outgoing');

    // NOTIFICATIONS PAGE
    Route::get('/notifications', [FriendRequestController::class, 'notifications'])
        ->name('notifications.list');

    // FRIEND REQUEST ACTIONS
    Route::get('/send-request/{id}', [FriendRequestController::class, 'sendRequest'])
        ->name('send.request');

    Route::get('/request/accept/{id}', [FriendRequestController::class, 'accept'])
        ->name('request.accept');

    Route::get('/request/reject/{id}', [FriendRequestController::class, 'reject'])
        ->name('request.reject');

    Route::get('/request/block/{id}', [FriendRequestController::class, 'block'])
        ->name('request.block');
});



Route::get('/searchusers', [UserController::class, 'search'])->name('users.search');



Route::get('/main', function () {
    return view('main');
});

Route::get('/report', [ReportController::class, 'index'])->name('report.index');
Route::get('/report/generate', [ReportController::class, 'generate'])->name('report.generate');

//Route::post('/generate-report', [ReportController::class, 'generate']);

Route::get('/run-chain', function () {
    Bus::chain([
        new StepOneJob(),
        new StepTwoJob(),
        new StepThreeJob(),
    ])->dispatch();

    return 'Job chain dispatched!';
});


Route::get('/send-email', function () {
    $user = User::first(); // Make sure a user exists
    SendWelcomeEmail::dispatch($user);

    return 'Email job dispatcheddddddddddddd!';
});


Route::get('/run-process', function () {
    $result = Process::run('dir');
    return nl2br($result->output()); // Convert newlines for HTML display
});

Route::get('/send-sms', [SmsController::class, 'sendSms']);


Route::get('/send-notification', [NotificationController::class, 'sendNotification']);


Route::get('/send-mail', [MailController::class, 'sendMail']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');



Route::get('/get-posts', [HttpClientController::class, 'getPosts']);
Route::get('/create-post', [HttpClientController::class, 'createPost']);

// Route::get('/files', [FileController::class, 'index'])->name('file.index');
// Route::post('/download', [FileController::class, 'download'])->name('file.download');

// Route::post('/uploads', [FileController::class, 'upload']);
// Route::get('/download/{filename}', [FileController::class, 'download']);
// Route::get('/read/{filename}', [FileController::class, 'read']);
// Route::post('/write/{filename}', [FileController::class, 'write']);

Route::get('/files', [FileController::class, 'index']); // Show upload form + file list
Route::post('/files/upload', [FileController::class, 'upload']); // Upload file
Route::delete('/files/delete', [FileController::class, 'delete']); // Delete file



Route::get('/log', [LogController::class, 'store']);

Route::get('/cache-demo', function () {
    // Store data
    Cache::put('college', 'MVM Commerce, Management & IT', 60);

    // Retrieve data
    $college = Cache::get('college');

    return "College Name from Cache: " . $college;
});


Route::get('/serialize-demo',function(){
    $user = User::take(3)->get();
    $serialized = serialize($user);
    $unserialized = unserialize($serialized);
    $json = $user->tojson();

    return view('serialize-demo',[
        'users' => $user,
        'serialized'=>$serialized,
        'unserialized' =>$unserialized,
        'json'=> $json,
    ]);
});

Route::get('/time', function () {
    return [
        'laravel_timezone' => config('app.timezone'),
        'carbon_time' => now(),
    ];
});

Route::get('/run-command', function () {
    $exitCode = Artisan::call('my:customcommand', [
        'name' => 'Shreya',          // argument
        '--greeting' => 'Hii',       // option
    ]);

    // Optional: get the output of the command
    $output = Artisan::output();

    return "<pre>$output</pre>";
});

Route::get('/user/{id}', [UserCacheController::class, 'getUser']);
Route::put('/user/{id}', [UserCacheController::class, 'updateUser']);
Route::delete('/user/{id}', [UserCacheController::class, 'deleteUser']);
Route::get('/custom-cache', [UserCacheController::class, 'customCache']);
Route::get('/students/{id}/courses-view', function ($id) {
    $student = Student::findOrFail($id);
    return view('student_courses', ['student' => $student]);
});



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Show the upload form
Route::get('/upload', [FileUploadController::class, 'showForm'])->name('upload.form');

// Handle the file upload
Route::post('/upload', [FileUploadController::class, 'handleUpload'])->name('upload.handle');




// Route::get('/users', [UserController::class, 'index']);

Route::get('/', function () {
    return view('welcome');
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
