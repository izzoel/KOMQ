<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RewardController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [QuizController::class, 'index']);

Route::get('/admin', [AdminController::class, 'index']);


// Tampilkan soal
Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.take');
Route::get('/quiz/{kategori}', [QuizController::class, 'show'])->name('quiz.show');
Route::get('/reward', [QuizController::class, 'reward'])->name('quiz.reward');
Route::get('/reward/list', [RewardController::class, 'show'])->name('reward.list');

Route::post('/reward/add/{id}', [RewardController::class, 'add']);
Route::post('/reward/minus/{id}', [RewardController::class, 'minus']);
Route::post('/reward/store', [RewardController::class, 'store']);
Route::get('/reward/{id}/edit', [RewardController::class, 'editReward']);
Route::post('/reward/edit', [RewardController::class, 'edit']);
Route::post('/reward/used', [RewardController::class, 'update']);
Route::post('/reward/toggle', [RewardController::class, 'toggle']);


// Jawab soal
Route::post('/quiz/{kategori}/{id_soal}/{jawab}', [QuizController::class, 'update'])->name('jawab');
