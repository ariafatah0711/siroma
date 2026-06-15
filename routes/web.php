<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecruitmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/organisasi', [OrganizationController::class, 'index'])->name('organizations.index');
Route::get('/organisasi/{organization}', [OrganizationController::class, 'show'])->name('organizations.show');

Route::get('/rekrutmen', [RecruitmentController::class, 'index'])->name('recruitments.index');
Route::get('/rekrutmen/{period}', [RecruitmentController::class, 'show'])->name('recruitments.show');
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/rekrutmen/{period}/daftar', [RecruitmentController::class, 'apply'])->name('recruitments.apply');
    Route::post('/rekrutmen/{period}/daftar', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/pendaftaran/{application}', [ApplicationController::class, 'show'])->name('applications.show');
    Route::post('/pendaftaran/{application}/dokumen', [ApplicationController::class, 'uploadDocument'])->name('applications.uploadDocument');
    Route::delete('/pendaftaran/{application}/dokumen/{document}', [ApplicationController::class, 'deleteDocument'])->name('applications.deleteDocument');
});
