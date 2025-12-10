<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaDashboardController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPengaduanController;
use App\Http\Controllers\Teknisi\TeknisiDashboardController;


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])
        ->name('mahasiswa.dashboard');

    Route::get('/pengaduan', [PengaduanController::class, 'create'])->name('pengaduan.create');
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');

    Route::get('/dashboard/riwayat', [PengaduanController::class, 'riwayat'])
        ->name('mahasiswa.riwayat');

    Route::get('/pengaduan/{id}', [PengaduanController::class, 'detail'])
        ->name('mahasiswa.pengaduan.detail');
    Route::get('/pengaduan/{id}/edit', [PengaduanController::class, 'edit'])
        ->name('pengaduan.edit');
    Route::patch('/pengaduan/{id}', [PengaduanController::class, 'update'])
        ->name('pengaduan.update');
    Route::delete('/pengaduan/{id}', [PengaduanController::class, 'destroy'])
        ->name('pengaduan.destroy');
    Route::get('/pengaduan/{id}/feedback', [PengaduanController::class, 'showFeedbackForm'])
        ->name('mahasiswa.pengaduan.feedback');
    Route::patch('/pengaduan/{id}/feedback', [\App\Http\Controllers\PengaduanController::class, 'feedback'])->name('pengaduan.feedback');
    Route::get('/feedback/riwayat', [MahasiswaDashboardController::class, 'riwayatFeedback'])->name('mahasiswa.feedback.riwayat');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/admin/pengaduan', [AdminPengaduanController::class, 'index'])
        ->name('admin.pengaduan.index');
    Route::get('/admin/pengaduan/{id}', [AdminPengaduanController::class, 'detail'])
        ->name('admin.pengaduan.detail');
    Route::post('/admin/pengaduan/{id}', [AdminPengaduanController::class, 'update'])
        ->name('admin.pengaduan.update');
});

Route::middleware(['auth', 'role:teknisi'])->group(function () {
    Route::get('/teknisi/dashboard', [TeknisiDashboardController::class, 'index'])
        ->name('teknisi.dashboard');
    Route::get('/teknisi/pengaduan/{id}', [TeknisiDashboardController::class, 'detail'])
        ->name('teknisi.pengaduan.detail');
    Route::post('/teknisi/pengaduan/{id}', [TeknisiDashboardController::class, 'update'])
        ->name('teknisi.pengaduan.update');
    Route::get('/teknisi/pengaduan/{id}/dokumentasi', [TeknisiDashboardController::class, 'dokumentasiForm'])
        ->name('teknisi.pengaduan.dokumentasi');
    Route::post('/teknisi/pengaduan/{id}/dokumentasi', [TeknisiDashboardController::class, 'dokumentasiStore'])
        ->name('teknisi.pengaduan.dokumentasi.store');
    Route::get('/teknisi/tugas', [TeknisiDashboardController::class, 'tasks'])->name('teknisi.tasks');
    Route::get('/teknisi/tugas/{id}', [TeknisiDashboardController::class, 'taskDetail'])->name('teknisi.tasks.detail');
    Route::get('/teknisi/feedback', [\App\Http\Controllers\Teknisi\TeknisiFeedbackController::class, 'index'])->name('teknisi.feedback');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/', function () {
    return redirect('/login');
});
