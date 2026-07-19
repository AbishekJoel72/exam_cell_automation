<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FacultiesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectsController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\FacultyMiddleware;
use App\Http\Middleware\StudentMiddleware;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/clear-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    return "All cache cleared successfully";
});

Route::any('/',[LoginController::class,'login'])->name('login');
Route::any('/password_request',[LoginController::class,'passwordRequest'])->name('password_request');
Route::any('/password_update',[LoginController::class,'passwordUpdate'])->name('password.update');
Route::any('/logout',[LoginController::class,'logout'])->name('logout');

Route::middleware([AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::any('dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
    Route::any('department',[DepartmentController::class,'department'])->name('department');
    Route::any('excel_upload',[DepartmentController::class,'excelUpload'])->name('excel_upload');
    Route::any('course',[CourseController::class,'course'])->name('course');
    Route::any('course_excel_upload',[CourseController::class,'courseexcelUpload'])->name('course_excel_upload');
    Route::any('subject',[SubjectsController::class,'subject'])->name('subject');
    Route::any('subject_excel_upload',[SubjectsController::class,'subjectexcelUpload'])->name('subject_excel_upload');
    Route::any('data.subject.filter',[SubjectsController::class,'subjectFilter'])->name('data.subject.filter');
    Route::any('classroom',[ClassroomController::class,'classroom'])->name('classroom');
    Route::any('classroom_excel_upload',[ClassroomController::class,'classroomexcelUpload'])->name('classroom_excel_upload');
    Route::any('students',[StudentController::class,'students'])->name('students');
    Route::any('faculty',[FacultiesController::class,'faculty'])->name('faculty');
});

Route::middleware([FacultyMiddleware::class])->prefix('faculty')->group(function () {

});

Route::middleware([StudentMiddleware::class])->prefix('student')->group(function () {

});

