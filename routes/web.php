<?php

use App\Http\Controllers\AnggotaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\RecapController;

Route::middleware('auth:anggota')->group(function () {
    Route::resource('/home',HomeController::class);
    Route::post('/home/inputPresence/{id}', [HomeController::class, 'inputPresence'])->name('inputPresence');
    Route::get('/profil', [HomeController::class, 'profil'])->name('home.profil');

    Route::get('/change-password-user', [AuthController::class, 'showChangePasswordUser'])->name('change.password.user');
    Route::post('/change-password-user', [AuthController::class, 'changePasswordUser'])->name('change.password.user');
});
Route::middleware('auth:web,teacher')->group(function () {
//     Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
        Route::resource('/users', AnggotaController::class);

        Route::post('users-reset-password/{id}',[AnggotaController::class,'resetPassword'])->name('users.resetPassword');
        Route::post('teacher-reset-password/{id}',[TeacherController::class,'resetPassword'])->name('teacher.resetPassword');
        Route::post('admin-reset-password/{id}',[AdminController::class,'resetPassword'])->name('admin.resetPassword');

        Route::get('/recap', [RecapController::class, 'index'])->name('recap.index');

        Route::resource('/attendance', AttendanceController::class);
        Route::post('/attendance/select-class', [AttendanceController::class, 'selectClass'])->name('attendance.select-class');

        Route::resource('/classroom', ClassroomController::class);
        Route::resource('/lesson', LessonController::class);
        Route::resource('/teacher', TeacherController::class);
        Route::resource('/admin', AdminController::class);

        Route::put('/presence/{attendanceId}/update-presence-status', [PresenceController::class, 'updatePresenceStatusByAttendance'])->name('updatePresenceStatusByAttendance');
        Route::resource('/presence', PresenceController::class);
        Route::get('/presence/presence-table/{id}', [PresenceController::class, 'presenceTable'])->name('presence.presence-table');
        Route::get('/presence/presence-table/not-presence/{id}',[PresenceController::class,'notPresence'])->name('presence.not-presence');
        Route::post('/presence/presence-table/not-presence/add-absent-member/{id}', [PresenceController::class, 'addAbsentMember'])->name('add.absent.member');
        Route::get('/auto-add-not-presence/{id}', [PresenceController::class, 'autoAddNotPresence'])->name('auto-add-not-presence');
        Route::get('/auto-add-not-presence-all', [PresenceController::class, 'autoAddNotPresenceAll'])->name('auto-add-not-presence-all');
        
        Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('change.password.form');
        Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change.password');

        Route::get('/download-siswa', [AnggotaController::class, 'downloadSiswa'])->name('download-siswa');
        Route::post('/upload-siswa', [AnggotaController::class, 'uploadSiswa'])->name('upload-siswa');
        Route::get('/download-teacher', [TeacherController::class, 'downloadTeacher'])->name('download-teacher');
        Route::post('/upload-teacher', [TeacherController::class, 'uploadTeacher'])->name('upload-teacher'); 
        Route::get('/download-classroom', [ClassroomController::class, 'downloadClassroom'])->name('download-classroom');
        Route::post('/upload-classroom', [ClassroomController::class, 'uploadClassroom'])->name('upload-classroom');       
        Route::get('/download-lesson', [LessonController::class, 'downloadLesson'])->name('download-lesson');
        Route::post('/upload-lesson', [LessonController::class, 'uploadLesson'])->name('upload-lesson');       
        Route::get('/download-presence', [PresenceController::class, 'downloadPresence'])->name('download-presence');
        Route::get('/download-presence-all', [PresenceController::class, 'downloadPresenceAll'])->name('download-presence-all');
        Route::get('/download-recap/{id}', [RecapController::class, 'downloadRecap'])->name('download-recap');

        Route::post('/reset-teachers', [TeacherController::class, 'resetTeachers'])->name('reset-teachers');
        Route::post('/reset-users', [AnggotaController::class, 'resetUsers'])->name('reset-users');
        Route::post('/reset-lessons', [LessonController::class, 'resetLessons'])->name('reset-lessons');
        Route::post('/reset-classrooms', [ClassroomController::class, 'resetClassrooms'])->name('reset-classrooms');
        Route::post('/reset-attendances', [AttendanceController::class, 'resetAttendances'])->name('reset-attendances');

});

Route::get('/logout',[AuthController::class,'logout'])->name('logout')->middleware('auth:web,anggota,teacher');

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('auth.login');
    Route::post('/', [AuthController::class, 'login']);
});





