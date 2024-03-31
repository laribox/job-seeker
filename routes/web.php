<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\isEmployer;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard')->with('success', 'Email verified!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!')->with('resend', 'resend');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/users/employer', [UsersController::class, 'employerRegisterView']);
Route::post('/users/employer', [UsersController::class, 'employerRegister'])->name('user.employerRegister');

Route::get('/users/seeker', [UsersController::class, 'registerView']);
Route::post('/users/seeker', [UsersController::class, 'register'])->name('user.register');

Route::get('/login', [UsersController::class, 'loginView'])->name('loginView');
Route::post('/login', [UsersController::class, 'login'])->name('login');

Route::post('/logout', [UsersController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'verified']);
Route::get('/verify', [DashboardController::class, 'verify'])->name('verification.notice');

Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions')->middleware(['auth', 'verified', isEmployer::class]);
Route::get('/weekly-subscriptions', [SubscriptionController::class, 'payment'])->name('weekly')->middleware(['auth', 'verified', isEmployer::class]);
Route::get('/monthly-subscriptions', [SubscriptionController::class, 'payment'])->name('monthly')->middleware(['auth', 'verified', isEmployer::class]);
Route::get('/yearly-subscriptions', [SubscriptionController::class, 'payment'])->name('yearly')->middleware(['auth', 'verified', isEmployer::class]);
