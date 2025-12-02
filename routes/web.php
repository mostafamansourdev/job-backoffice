<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // companies resource routes
    Route::resource('/companies', CompanyController::class);
    Route::put('/companies/{id}/restore', [CompanyController::class, 'restore'])->name('companies.restore');

    // job categories resource routes
    Route::resource('/job-categories', JobCategoryController::class);
    Route::put('/job-categories/{id}/restore', [JobCategoryController::class, 'restore'])->name('job-categories.restore');

    // job applications resource routes
    Route::resource('/job-applications', JobApplicationController::class);
    Route::put('/job-applications/{id}/restore', [JobApplicationController::class, 'restore'])->name('job-applications.restore');

    // job vacancies resource routes
    Route::resource('/job-vacancies', JobVacancyController::class);
    Route::put('/job-vacancies/{id}/restore', [JobVacancyController::class, 'restore'])->name('job-vacancies.restore');

    // users resource routes
    Route::resource('/users', UserController::class);
    Route::put('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
