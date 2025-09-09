<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    AuthController,
    CourseDetailController,
    DashboardController,
    ManageCourseController,
    MaterialController,
    ManageUserController,
    CourseUserController,
    MaterialUserController,
    ExamController,
    CertificateController,
    ManageCategoryController,
    ManageExamController
};

// =================== AUTH ===================
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');
});

// =================== HOME / DASHBOARD ===================
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // =================== COURSE DETAIL ===================
    Route::get('/course/{id}', [CourseDetailController::class, 'index'])->name('course-detail');

    // =================== MANAGE COURSE ===================
    Route::prefix('manage-course')->name('manage-course.')->group(function () {
        Route::get('/', [ManageCourseController::class, 'index'])->name('index');
        Route::get('/create', [ManageCourseController::class, 'create'])->name('create');
        Route::post('/', [ManageCourseController::class, 'store'])->name('store');
        Route::get('/{course}/edit', [ManageCourseController::class, 'edit'])->name('edit');
        Route::put('/{course}', [ManageCourseController::class, 'update'])->name('update');
        Route::delete('/{course}', [ManageCourseController::class, 'destroy'])->name('destroy');
        Route::get('/{course}/detail', [ManageCourseController::class, 'detail'])->name('detail');
        Route::post('/{course}/assign', [CourseUserController::class, 'assign'])->name('assign');
    });

    // =================== MATERIAL ===================
    Route::prefix('material')->name('material.')->group(function () {
        Route::get('/{course}/list', [MaterialController::class, 'index'])->name('index');
        Route::get('/{course}/create', [MaterialController::class, 'create'])->name('create');
        Route::post('/{course}', [MaterialController::class, 'store'])->name('store');
        Route::get('/{course}/{material}/edit', [MaterialController::class, 'edit'])->name('edit');
        Route::put('/{course}/{material}', [MaterialController::class, 'update'])->name('update');
        Route::delete('/{course}/{material}', [MaterialController::class, 'destroy'])->name('destroy');

        // complete material
        Route::post('/{material}/complete', [MaterialUserController::class, 'complete'])->name('complete');
    });

    // =================== MANAGE USER ===================
    Route::prefix('manage-user')->name('manage-user.')->group(function () {
        Route::get('/', [ManageUserController::class, 'index'])->name('index');
        Route::get('/create', [ManageUserController::class, 'create'])->name('create');
        Route::post('/', [ManageUserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [ManageUserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [ManageUserController::class, 'update'])->name('update');
        Route::delete('/{user}', [ManageUserController::class, 'destroy'])->name('destroy');
    });

    // =================== EXAM & CERTIFICATE ===================
    Route::prefix('course/{course}')->group(function () {
        Route::get('/final-exam', [ExamController::class, 'show'])->name('exam.show');
        Route::post('/final-exam', [ExamController::class, 'submit'])->name('exam.submit');
        Route::get('/certificate', [CertificateController::class, 'downloadCertificate'])->name('certificate.download');
    });

    // =================== CATEGORY ===================
    Route::prefix('manage-category')->name('manage-category.')->group(function () {
        Route::get('/', [ManageCategoryController::class, 'index'])->name('index');
        Route::post('/', [ManageCategoryController::class, 'store'])->name('store');
        Route::put('/{id}', [ManageCategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [ManageCategoryController::class, 'destroy'])->name('destroy');
    });

    // =================== MANAGE EXAM ===================
    Route::prefix('manage-exam')->name('manage-exam.')->group(function () {
        Route::get('/', [ManageExamController::class, 'index'])->name('index');
        Route::get('/{course}', [ManageExamController::class, 'show'])->name('show');
        Route::post('/store', [ManageExamController::class, 'store'])->name('store');
        Route::put('/{exam}/update', [ManageExamController::class, 'update'])->name('update');
        Route::delete('/{exam}/delete', [ManageExamController::class, 'destroy'])->name('destroy');
    });
});
