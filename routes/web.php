<?php

use App\Http\Controllers\BackupController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\Configurations\CourseController;
use App\Http\Controllers\Configurations\BuildingController;
use App\Http\Controllers\Configurations\CurriculumController;
use App\Http\Controllers\Configurations\RoomTypeController;
use App\Http\Controllers\Configurations\SettingsController;
use App\Http\Controllers\Configurations\DepartmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


Route::middleware(['auth'])->group(function(){

    Route::middleware(['role:superadmin'])->group(function(){
        Route::get('/roles-permissions', [SettingsController::class, 'rolesAndPermissions'])->name('settings.roles-permissions');
        Route::get('/users', [UserController::class, 'index'])->name('users.index');

        Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
        Route::get('/backup/create', [BackupController::class, 'create'])->name('backup.create');
        Route::get('/backup/download/{file_name}', [BackupController::class, 'download'])->name('backup.download');
        Route::get('/backup/delete/{file_name}', [BackupController::class, 'delete'])->name('backup.delete');
    });

    Route::middleware(['role:superadmin|admin'])->group(function(){
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

        Route::resource('departments', DepartmentController::class);
        Route::resource('courses', CourseController::class);
        Route::resource('courses.curricula', CurriculumController::class)->except('index')->shallow();

        Route::resource('buildings', BuildingController::class);
        Route::resource('room-type', RoomTypeController::class);
        Route::resource('rooms', RoomController::class);
        Route::resource('sections', SectionController::class);
        Route::resource('subjects', SubjectController::class);

        Route::get('/schedule/course', [ScheduleController::class, 'index'])->name('schedule.course');
        Route::get('/schedule/subject', [ScheduleController::class, 'bySubject'])->name('schedule.subject');

        Route::get('/course/sections/{course}', [CourseController::class, 'showAllSections'])->name('course.sections.show');

    });

    Route::resource('faculties', FacultyController::class);
    Route::get('/change-password', [SettingsController::class, 'changePassword'])->name('password.change');
    Route::post('/change-password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');

});

require __DIR__.'/auth.php';
