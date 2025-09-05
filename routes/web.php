<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rute Publik (Bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/portofolio', [PublicController::class, 'gallery'])->name('portofolio.gallery');
Route::get('/siswa/{user:name}', [PublicController::class, 'showSiswa'])->name('siswa.show');
Route::get('/portofolio/{project}', [PublicController::class, 'show'])->name('portofolio.show');


/*
|--------------------------------------------------------------------------
| Rute Internal (Memerlukan login)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('projects', ProjectController::class)->except(['show', 'index']); 
    Route::get('/my-projects', [ProjectController::class, 'index'])->name('projects.index'); 
    Route::patch('/projects/{project}/submit', [ProjectController::class, 'submitForReview'])->name('projects.submit');
    Route::get('/projects/{project}/preview', [ProjectController::class, 'preview'])->name('projects.preview');
    Route::post('/projects/{project}/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
});

// Rute untuk Guru & Admin
Route::middleware(['auth', 'role:guru,admin'])->group(function () {
    Route::get('/review', [ReviewController::class, 'index'])->name('review.index');
    Route::get('/review/{project}', [ReviewController::class, 'show'])->name('review.show');
    Route::patch('/review/{project}/approve', [ReviewController::class, 'approve'])->name('review.approve');
    Route::patch('/review/{project}/reject', [ReviewController::class, 'reject'])->name('review.reject');
});

// Rute KHUSUS untuk Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::get('projects', [\App\Http\Controllers\Admin\ProjectController::class, 'index'])->name('projects.index');
    Route::patch('projects/{project}/retract', [\App\Http\Controllers\Admin\ProjectController::class, 'retract'])->name('projects.retract');
    Route::patch('projects/{project}/toggle-feature', [\App\Http\Controllers\Admin\ProjectController::class, 'toggleFeature'])->name('projects.toggle-feature'); 
});

require __DIR__.'/auth.php';