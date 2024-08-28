<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\UserEmailChangeController;
use App\Http\Controllers\Auth\UserManagementController;
use App\Http\Controllers\Auth\UserProfileController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\UserPasswordChangeController;
use App\Http\Middleware\geolocationNotification;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisteredUserController::class, 'store'])
                ->middleware([ 'auth:sanctum'])
                ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware(['guest', geolocationNotification::class])
                ->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware('guest')
                ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
                ->middleware('guest')
                ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware([ 'throttle:6,1'])
                ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['auth', 'throttle:6,1'])
                ->name('verification.send');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth')
                ->name('logout');

Route::get('/user', [UserManagementController::class, 'index'])
->middleware(['auth', 'auth:sanctum'])
->name("userManagement.index");

Route::post('/user/{user}/toggleAdmin', [UserManagementController::class, 'toggleAdmin'])
->middleware(['auth', 'auth:sanctum'])
->name("userManagement.toggleAmin");

Route::match(['patch', 'put'], '/user/email', UserEmailChangeController::class)
->middleware(['auth', 'auth:sanctum', 'throttle:6,1'])
->name("user.changeEmail");

Route::match(['patch', 'put'], '/user/password', UserPasswordChangeController::class)
->middleware(['auth', 'auth:sanctum', 'throttle:6,1'])
->name("user.changePassword");

Route::match(['patch', 'put', 'post'], '/user', [UserProfileController::class, 'update'])
->middleware(['auth', 'auth:sanctum'])
->name("user.profile.update");

Route::delete('/user/delete', [UserProfileController::class, 'deleteRequest'])
->middleware(['auth', 'auth:sanctum', 'throttle:6,1'])
->name("user.profile.delete");

Route::get('/verify-delete/{user}', [UserProfileController::class, 'destroyUser'])
->middleware([ 'throttle:6,1'])
->name('verification.delete');