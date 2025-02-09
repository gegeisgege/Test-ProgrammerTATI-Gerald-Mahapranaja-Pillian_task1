<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Protect routes with authentication middleware
Route::middleware(['auth'])->group(function () {
    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Employees Routes (Basic CRUD)
    Route::resource('employee', EmployeeController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);


    // Logs Routes (CRUD, approval only for Supervisors)
    Route::resource('logs', LogController::class)->except(['edit', 'update', 'destroy']);
    
    Route::middleware(['role:Supervisor'])->group(function () {
        Route::patch('/logs/{log}/approve', [LogController::class, 'approve'])->name('logs.approve');
        Route::patch('/logs/{log}/reject', [LogController::class, 'reject'])->name('logs.reject');
    });

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Explicitly Added "profile.show"
    Route::get('/profile/show', [ProfileController::class, 'edit'])->name('profile.show');

    // Added missing "account.delete" route
    Route::delete('/account/delete', [ProfileController::class, 'destroy'])->name('account.delete');

    // Password Update Route
    Route::post('/password/update', [PasswordController::class, 'update'])->name('password.update');

    // Email Verification Routes
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/dashboard')->with('success', 'Email verified successfully.');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

// Redirect '/' to dashboard only if user is logged in
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
})->name('home');

// Debugging Route (Check if logs.index is working)
Route::get('/logs-test', function () {
    return "Logs route is working!";
})->name('logs.test');

// Logout Route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
