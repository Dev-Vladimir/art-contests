<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ContestsController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AuthController;

Route::view('/', 'welcome')->name('home');
Route::view('/about', 'guest.about')->name('about');
Route::view('/contact', 'guest.contact')->name('contact');
Route::view('/confidential-policy', 'guest.policy')->name('policy');

Route::get('/contests', [IndexController::class, 'contests'])->name('contests.list');
Route::get('/news', [IndexController::class, 'news'])->name('news');

//для юзеров
Route::group(['middleware' => ['auth', 'verified']], function(){
    Route::get('/user/contests', [ContestsController::class, 'index'])->name('user.contests.index');
    Route::get('/user/contests/new', [ContestsController::class, 'create'])->name('user.contests.new');
    Route::post('/user/contests/new', [ContestsController::class, 'store']);
    Route::get('/user/contests/edit/{id}', [ContestsController::class, 'edit'])->name('user.contests.edit');
    Route::post('/user/contests/edit/{id}', [ContestsController::class, 'update'])->name('user.contests.update');
    Route::get('/user/contests/show/{id}', [ContestsController::class, 'show'])->name('user.contests.show');
    Route::get('/user/contests/delete/{id}', [ContestsController::class, 'destroy'])->name('user.contests.delete');

    Route::get('/user/forms', [FormsController::class, 'index'])->name('user.forms.index');
    Route::get('/user/forms/create', [FormsController::class, 'create'])->name('user.forms.new');
    Route::post('/user/forms/create', [FormsController::class, 'store'])->name('user.forms.store');
    Route::get('/user/forms/edit/{id}', [FormsController::class, 'edit'])->name('user.forms.edit');
    Route::post('/user/forms/edit/{id}', [FormsController::class, 'update'])->name('user.forms.update');
    Route::get('/user/forms/show/{id}', [FormsController::class, 'show'])->name('user.forms.show');
    Route::get('/user/forms/delete/{id}', [FormsController::class, 'destroy'])->name('user.forms.delete');

    Route::get('user', [UsersController::class, 'dashboard'])->name('dashboard');
    Route::get('user/edit', [UsersController::class, 'edit'])->name('user.edit');
    Route::post('user/edit', [UsersController::class, 'updateProfile']);
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});






// Гостевые маршруты (только для неавторизованных)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'storeRegister']);
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'storeLogin']);
    Route::get('/forgot-password', [AuthController::class, 'forgotPasswordForm'])
        ->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
        ->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])
        ->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->name('password.update');
});

// Маршруты верификации (доступны и гостям, и пользователям, но обычно гостям)
Route::get('/email/verify', [AuthController::class, 'verifyNotice'])
    ->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])
    ->name('verification.verify');
Route::post('/email/resend', [AuthController::class, 'resend'])
    ->name('verification.resend');