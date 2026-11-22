<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Office;
use App\Http\Controllers\Student;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect(AuthController::home(auth()->user())) : view('welcome');
})->name('welcome');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:10,1');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'role:student'])->name('student.')->group(function () {
    Route::get('/home', [Student\ScreeningController::class, 'home'])->name('home');
    Route::get('/check-in', [Student\ScreeningController::class, 'create'])->name('screenings.create');
    Route::post('/check-in', [Student\ScreeningController::class, 'store'])->name('screenings.store');
    Route::get('/results/{screening}', [Student\ScreeningController::class, 'show'])->name('screenings.show');
    Route::post('/results/{screening}/referral', [Student\ReferralController::class, 'store'])->name('referrals.store');
    Route::get('/my-results', [Student\ScreeningController::class, 'history'])->name('history');
    Route::get('/messages', [Student\MessageController::class, 'index'])->name('messages');
    Route::post('/messages', [Student\MessageController::class, 'store'])->name('messages.store');
});

Route::middleware(['auth', 'role:counselor,admin'])->prefix('office')->name('office.')->group(function () {
    Route::get('/referrals', [Office\ReferralController::class, 'index'])->name('referrals.index');
    Route::get('/referrals/{referral}', [Office\ReferralController::class, 'show'])->name('referrals.show');
    Route::put('/referrals/{referral}', [Office\ReferralController::class, 'update'])->name('referrals.update');
    Route::get('/messages', [Office\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{conversation}', [Office\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [Office\MessageController::class, 'reply'])->name('messages.reply');
    Route::get('/overview', Office\OverviewController::class)->name('overview');
});

Route::middleware(['auth', 'role:admin'])->prefix('office')->name('office.')->group(function () {
    Route::get('/settings', [Office\SettingsController::class, 'edit'])->name('settings');
    Route::put('/settings', [Office\SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/staff', [Office\SettingsController::class, 'addStaff'])->name('settings.staff');
});
