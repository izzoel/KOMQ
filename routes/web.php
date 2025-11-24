<?php

use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [QuizController::class, 'index']);
// Tampilkan soal
Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.take');
Route::get('/quiz/{kategori}', [QuizController::class, 'show'])->name('quiz.show');

// Jawab soal
Route::post('/quiz/{kategori}/{id_soal}/{jawab}', [QuizController::class, 'update'])->name('jawab');
