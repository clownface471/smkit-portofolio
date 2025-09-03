<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('projects', ProjectController::class);
    Route::patch('/projects/{project}/submit', [ProjectController::class, 'submitForReview'])->name('projects.submit');
});

// Rute untuk Guru & Admin
Route::middleware(['auth', 'role:guru,admin'])->group(function () {
    Route::get('/review', [ReviewController::class, 'index'])->name('review.index');
    Route::patch('/review/{project}/approve', [ReviewController::class, 'approve'])->name('review.approve');
    Route::patch('/review/{project}/reject', [ReviewController::class, 'reject'])->name('review.reject');
});

require __DIR__.'/auth.php';

