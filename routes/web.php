<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiaryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ursprüngliche Welcome-Route
// Route::get('/', function () {
//     return view('welcome');
// });

// Tagebuch-Routen
Route::get('/', [DiaryController::class, 'index'])->name('diary.index');

Route::get('/create', [DiaryController::class, 'create'])->name('diary.create');

Route::post('/', [DiaryController::class, 'store'])->name('diary.store');

Route::get('/{id}', [DiaryController::class, 'show'])->name('diary.show');

Route::get('/{id}/edit', [DiaryController::class, 'edit'])->name('diary.edit');

Route::put('/{id}', [DiaryController::class, 'update'])->name('diary.update');

Route::delete('/{id}', [DiaryController::class, 'destroy'])->name('diary.destroy');