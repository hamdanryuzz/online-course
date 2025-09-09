<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    HomeController,
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

// ================= AUTH =================
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// ================= PROTECTED ROUTES =================
Route::middleware('auth:sanctum')->group(function () {
    // HOME & DASHBOARD
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // COURSE DETAIL
    Route::get('/course/{id}', [CourseDetailController::class, 'show']);

    // MANAGE COURSE
    Route::prefix('manage-course')->group(function () {
        Route::get('/', [ManageCourseController::class, 'index']);
        Route::post('/', [ManageCourseController::class, 'store']);
        Route::get('/{course}', [ManageCourseController::class, 'show']);
        Route::put('/{course}', [ManageCourseController::class, 'update']);
        Route::delete('/{course}', [ManageCourseController::class, 'destroy']);
        Route::post('/{course}/assign', [CourseUserController::class, 'assign']);
    });

    // MATERIAL
    Route::prefix('material')->group(function () {
        Route::get('/{course}/list', [MaterialController::class, 'index']);
        Route::post('/{course}', [MaterialController::class, 'store']);
        Route::get('/{course}/{material}', [MaterialController::class, 'show']);
        Route::put('/{course}/{material}', [MaterialController::class, 'update']);
        Route::delete('/{course}/{material}', [MaterialController::class, 'destroy']);

        // complete material
        Route::post('/{material}/complete', [MaterialUserController::class, 'complete']);
    });

    // MANAGE USER
    Route::prefix('users')->group(function () {
        Route::get('/', [ManageUserController::class, 'index']);
        Route::post('/', [ManageUserController::class, 'store']);
        Route::get('/{user}', [ManageUserController::class, 'show']);
        Route::put('/{user}', [ManageUserController::class, 'update']);
        Route::delete('/{user}', [ManageUserController::class, 'destroy']);
    });

    // EXAM & CERTIFICATE
    Route::prefix('course/{course}')->group(function () {
        Route::get('/final-exam', [ExamController::class, 'show']);
        Route::post('/final-exam', [ExamController::class, 'submit']);
        Route::get('/certificate', [CertificateController::class, 'downloadCertificate']);
    });

    // CATEGORY
    Route::prefix('categories')->group(function () {
        Route::get('/', [ManageCategoryController::class, 'index']);
        Route::post('/', [ManageCategoryController::class, 'store']);
        Route::put('/{id}', [ManageCategoryController::class, 'update']);
        Route::delete('/{id}', [ManageCategoryController::class, 'destroy']);
    });

    // MANAGE EXAM
    Route::prefix('exams')->group(function () {
        Route::get('/', [ManageExamController::class, 'index']);
        Route::get('/{courseId}', [ManageExamController::class, 'show']);
        Route::post('/', [ManageExamController::class, 'store']);
        Route::put('/{exam}', [ManageExamController::class, 'update']);
        Route::delete('/{exam}', [ManageExamController::class, 'destroy']);
    });
});
