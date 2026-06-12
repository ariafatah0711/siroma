<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\RecruitmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/organisasi', [OrganizationController::class, 'index'])->name('organizations.index');
Route::get('/organisasi/{organization}', [OrganizationController::class, 'show'])->name('organizations.show');

Route::get('/rekrutmen', [RecruitmentController::class, 'index'])->name('recruitments.index');
Route::get('/rekrutmen/{period}', [RecruitmentController::class, 'show'])->name('recruitments.show');
Route::get('/rekrutmen/{period}/daftar', [RecruitmentController::class, 'apply'])->name('recruitments.apply');
Route::post('/rekrutmen/{period}/daftar', [ApplicationController::class, 'store'])->name('applications.store');

Route::get('/pendaftaran/{application}', [ApplicationController::class, 'show'])->name('applications.show');
