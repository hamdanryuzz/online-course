<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseDetailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManageCourseController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\CourseUserController;
use App\Http\Controllers\MaterialUserController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ManageCategoryController;
use App\Http\Controllers\ManageExamController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

Route::get('/course/{id}', [CourseDetailController::class, 'index'])->name('course-detail')->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/manage-course', [ManageCourseController::class, 'index'])->name('manage-course.index');
    Route::get('/manage-course/create', [ManageCourseController::class, 'create'])->name('manage-course.create');
    Route::post('/manage-course', [ManageCourseController::class, 'store'])->name('manage-course.store');
    Route::get('/manage-course/{course}/edit', [ManageCourseController::class, 'edit'])->name('manage-course.edit');
    Route::put('/manage-course/{course}', [ManageCourseController::class, 'update'])->name('manage-course.update');
    Route::delete('/manage-course/{course}', [ManageCourseController::class, 'destroy'])->name('manage-course.destroy');
    Route::get('/manage-course/{course}/detail', [ManageCourseController::class, 'detail'])->name('manage-course.detail');

    Route::get('/material/{course}/list', [MaterialController::class, 'index'])->name('material.index');
    Route::get('/material/{course}/create', [MaterialController::class, 'create'])->name('material.create');
    Route::post('/material/{course}', [MaterialController::class, 'store'])->name('material.store');
    Route::get('/material/{course}/{material}/edit', [MaterialController::class, 'edit'])->name('material.edit');
    Route::put('/material/{course}/{material}', [MaterialController::class, 'update'])->name('material.update');
    Route::delete('/material/{course}/{material}', [MaterialController::class, 'destroy'])->name('material.destroy');

    Route::get('/manage-user', [ManageUserController::class, 'index'])->name('manage-user.index');
    Route::get('/manage-user/create', [ManageUserController::class, 'create'])->name('manage-user.create');
    Route::post('/manage-user', [ManageUserController::class, 'store'])->name('manage-user.store');
    Route::get('/manage-user/{user}/edit', [ManageUserController::class, 'edit'])->name('manage-user.edit');
    Route::put('/manage-user/{user}', [ManageUserController::class, 'update'])->name('manage-user.update');
    Route::delete('/manage-user/{user}', [ManageUserController::class, 'destroy'])->name('manage-user.destroy');
    Route::post('/manage-course/{course}/assign', [CourseUserController::class, 'assign'])->name('manage-course.assign');

    Route::post('/material/{material}/complete', [MaterialUserController::class, 'complete'])->name('material.complete');

    Route::get('/course/{course}/final-exam', [ExamController::class, 'show'])->name('exam.show');
    Route::post('/course/{course}/final-exam', [ExamController::class, 'submit'])->name('exam.submit');

    Route::get('/course/{course}/certificate', [CertificateController::class, 'downloadCertificate'])->name('certificate.download');

    Route::get('manage-category/', [ManageCategoryController::class, 'index'])->name('manage-category.index');
    Route::post('manage-category/', [ManageCategoryController::class, 'store'])->name('manage-category.store');
    Route::put('manage-category/{id}', [ManageCategoryController::class, 'update'])->name('manage-category.update');
    Route::delete('manage-category/{id}', [ManageCategoryController::class, 'destroy'])->name('manage-category.destroy');

    Route::prefix('manage-exam')->group(function () {
        Route::get('/', [ManageExamController::class, 'index'])->name('manage-exam.index');
        Route::get('/{course}', [ManageExamController::class, 'show'])->name('manage-exam.show');
        Route::post('/store', [ManageExamController::class, 'store'])->name('manage-exam.store');
        Route::put('/{exam}/update', [ManageExamController::class, 'update'])->name('manage-exam.update');
        Route::delete('/{exam}/delete', [ManageExamController::class, 'destroy'])->name('manage-exam.destroy');
    });


});
