<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\MateriController;

Route::get('/', [MateriController::class, 'index'])->name('materi.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/materi/saya', [MateriController::class, 'myMaterials'])->name('materi.user');
    Route::get('/materi/upload', [MateriController::class, 'create'])->name('materi.create');
    Route::post('/materi/upload', [MateriController::class, 'store'])->name('materi.store');
    Route::get('/materi/{materi}', [MateriController::class, 'show'])->name('materi.show');
    Route::post('/materi/{material}/komentar', [CommentController::class, 'store'])->name('komentar.store');
});


require __DIR__.'/auth.php';
