<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ExamsController;
use App\Http\Controllers\FacultiesController;
use App\Http\Controllers\InvigilatorAllocationsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SeatAllocationsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\ViewHallTickerController;
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
    Route::any('excel_upload',[DepartmentController::class,'DepartmentDataExport'])->name('department_export');
    Route::any('department_export',[DepartmentController::class,'excelUpload'])->name('excel_upload');
    Route::any('course',[CourseController::class,'course'])->name('course');
    Route::any('course_excel_upload',[CourseController::class,'courseexcelUpload'])->name('course_excel_upload');
    Route::any('courses_export',[CourseController::class,'CourseDataExport'])->name('courses_export');
    Route::any('subject',[SubjectsController::class,'subject'])->name('subject');
    Route::any('subject_excel_upload',[SubjectsController::class,'subjectexcelUpload'])->name('subject_excel_upload');
    Route::any('data.subject.filter',[SubjectsController::class,'subjectFilter'])->name('data.subject.filter');
    Route::any('subjects_export',[SubjectsController::class,'SubjectDataExport'])->name('subjects_export');
    Route::any('classroom',[ClassroomController::class,'classroom'])->name('classroom');
    Route::any('classroom_excel_upload',[ClassroomController::class,'classroomexcelUpload'])->name('classroom_excel_upload');
    Route::any('classroom_export',[ClassroomController::class,'ClassRoomDataExport'])->name('classroom_export');
    Route::any('students',[StudentController::class,'students'])->name('students');
    Route::any('add_student',[StudentController::class,'Addstudents'])->name('add_student');
    Route::any('student_credentials', [StudentController::class, 'student_credentials'])->name('student_credentials');
    Route::any('student_excel_upload',[StudentController::class,'studentsexcelUpload'])->name('student_excel_upload');
    Route::any('student_export',[StudentController::class,'StudentDataExport'])->name('student_export');
    Route::any('faculty',[FacultiesController::class,'faculty'])->name('faculty');
    Route::any('faculty_credentials',[FacultiesController::class,'faculty_credentials'])->name('faculty_credentials');
    Route::any('add_faculties',[FacultiesController::class,'AddFaculties'])->name('add_faculties');
    Route::any('faculties_excel_upload',[FacultiesController::class,'facultyexcelUpload'])->name('faculties_excel_upload');
    Route::any('faculty_export',[FacultiesController::class,'FacultyDataExport'])->name('faculty_export');
    Route::any('exams',[ExamsController::class,'Exam'])->name('exams');
    Route::any('exams_excel_upload',[ExamsController::class,'ExamexcelUpload'])->name('exams_excel_upload');
    Route::any('exams_export',[ExamsController::class,'ExamsDataExport'])->name('exams_export');
    Route::any('seat_allocate',[SeatAllocationsController::class,'SeatAllocate'])->name('seat_allocate');
    Route::any('seat_allocate_excel_upload',[SeatAllocationsController::class,'SeatAllocateExcelUpload'])->name('seat_allocate_excel_upload');
    Route::any('seatallocation_export',[SeatAllocationsController::class,'SeatAllocateDataExport'])->name('seatallocation_export');
    Route::any('invigilator_allocate',[InvigilatorAllocationsController::class,'InvigilatorAllocate'])->name('invigilator_allocate');
    Route::any('invigilator_excel_upload',[InvigilatorAllocationsController::class,'InvigilatorAllocateExcelUpload'])->name('invigilator_excel_upload');
    Route::any('invigilator_export',[InvigilatorAllocationsController::class,'InvigilatorAllocateDataExport'])->name('invigilator_export');
});

Route::middleware([FacultyMiddleware::class])->prefix('faculty')->group(function () {

});

Route::middleware([StudentMiddleware::class])->prefix('student')->group(function () {

Route::any('view_hall_ticker', [ViewHallTickerController::class, 'ViewHallTicket'])->name('view_hall_ticker');
});

