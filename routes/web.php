<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatabaseSekolahController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ImportSantriController;
use App\Http\Controllers\PublicCheckController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\SantriController;

// Auth routes (public) dilindungi rate limiter
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('login.throttle')
    ->name('login.post');

// Landing page (public)
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Redirect legacy URL /munaqasyah -> /database-sekolah
Route::get('/munaqasyah', function () {
    return redirect('/database-sekolah' . (request()->getQueryString() ? '?' . request()->getQueryString() : ''));
});
Route::get('/munaqasyah/{any}', function ($any) {
    return redirect('/database-sekolah/' . $any . (request()->getQueryString() ? '?' . request()->getQueryString() : ''));
})->where('any', '.*');

// Public routes
Route::get('/cek-kelulusan', [PublicCheckController::class, 'index'])->name('public.check');
Route::get('/cek-kelulusan/{id}', [PublicCheckController::class, 'show'])
    ->where('id', '[0-9]+')
    ->name('public.check.cetak');

// Layanan Chatbot FAQ
Route::post('/chatbot/ask', [ChatbotController::class, 'ask'])
    ->middleware('chatbot.throttle')
    ->name('chatbot.ask');

// Protected routes (wajib login)
Route::middleware('auth.check')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Biodata Santri
    Route::resource('santri', SantriController::class);

    // Database Sekolah & Penilaian
    Route::prefix('database-sekolah')->name('database_sekolah.')->group(function () {
        Route::get('/', [DatabaseSekolahController::class, 'index'])->name('index');
        Route::get('/tambah', [DatabaseSekolahController::class, 'create'])->name('create');
        Route::post('/', [DatabaseSekolahController::class, 'store'])->name('store');

        // Import Excel / CSV
        Route::get('/import', [ImportSantriController::class, 'showImportForm'])->name('import');
        Route::post('/import', [ImportSantriController::class, 'import'])->name('import.post');
        Route::get('/import/template', [ImportSantriController::class, 'downloadTemplate'])->name('import.template');

        // Export data
        Route::get('/export/excel', [DatabaseSekolahController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export/csv', [DatabaseSekolahController::class, 'exportCsv'])->name('export.csv');

        // Surat kelulusan
        Route::get('/cetak-massal', [DatabaseSekolahController::class, 'cetakMassal'])->name('cetak.massal');
        Route::get('/{id}/kelulusan', [DatabaseSekolahController::class, 'kelulusan'])
            ->where('id', '[0-9]+')
            ->name('kelulusan');

        // CRUD Edit & Update
        Route::get('/{id}/edit', [DatabaseSekolahController::class, 'edit'])
            ->where('id', '[0-9]+')
            ->name('edit');
        Route::put('/{id}', [DatabaseSekolahController::class, 'update'])
            ->where('id', '[0-9]+')
            ->name('update');

        // Hapus data santri (khusus Administrator)
        Route::delete('/{id}', [DatabaseSekolahController::class, 'destroy'])
            ->where('id', '[0-9]+')
            ->middleware('admin.only')
            ->name('destroy');
    });

    // Kelola pengguna (khusus Administrator)
    Route::resource('users', UserController::class)
        ->except(['show'])
        ->middleware('admin.only');

    // Pengaturan sistem & backup (khusus Administrator)
    Route::prefix('settings')->name('settings.')->middleware('admin.only')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/', [SettingController::class, 'update'])->name('update');
        Route::get('/backup', [SettingController::class, 'backup'])->name('backup');
    });
});
