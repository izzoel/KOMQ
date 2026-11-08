<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RewardController;
use Illuminate\Support\Facades\Route;

// --- Publik: Halaman Kuis & Doorprize Peserta ---
Route::get('/', [QuizController::class, 'index'])->name('home');
Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.take');
Route::get('/quiz/{kategori}', [QuizController::class, 'show'])->name('quiz.show');
Route::post('/quiz/{kategori}/{id_soal}/{jawab}', [QuizController::class, 'update'])->name('jawab');

Route::get('/reward', [QuizController::class, 'reward'])->name('quiz.reward');
Route::get('/reward/list', [RewardController::class, 'show'])->name('reward.list');
Route::post('/reward/used', [RewardController::class, 'update'])->name('reward.used');

// --- Autentikasi Admin ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'proses'])->name('proses');
});
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

// --- Khusus Admin (Dilindungi Middleware Auth) ---
Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    // Manajemen Reward oleh Admin
    Route::prefix('reward')->group(function () {
        Route::get('/set', [RewardController::class, 'set'])->name('reward.set');
        Route::get('/{id}/edit', [RewardController::class, 'editReward'])->name('reward.edit-data');
        Route::post('/add/{id}', [RewardController::class, 'add'])->name('reward.add');
        Route::post('/minus/{id}', [RewardController::class, 'minus'])->name('reward.minus');
        Route::post('/store', [RewardController::class, 'store'])->name('reward.store');
        Route::post('/edit', [RewardController::class, 'edit'])->name('reward.edit');
        Route::post('/toggle', [RewardController::class, 'toggle'])->name('reward.toggle');
    });

    // Manajemen Soal Kuis oleh Admin
    Route::prefix('admin/quiz')->group(function () {
        Route::get('/', [AdminController::class, 'quizIndex'])->name('admin.quiz.index');
        Route::post('/store', [AdminController::class, 'quizStore'])->name('admin.quiz.store');
        Route::get('/{id}/edit', [AdminController::class, 'quizEdit'])->name('admin.quiz.edit');
        Route::post('/update', [AdminController::class, 'quizUpdate'])->name('admin.quiz.update');
        Route::delete('/{id}', [AdminController::class, 'quizDestroy'])->name('admin.quiz.destroy');
    });
});

