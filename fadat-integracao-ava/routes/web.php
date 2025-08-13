<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Professor\ProfessorController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', function () {
    return Inertia::render('Home');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ROTA CURSOS
    Route::get('/course', [CourseController::class, 'index'])->name('course.index');
    Route::get('/course/create', [CourseController::class, 'create'])->name('course.create');
    Route::post('/course', [CourseController::class, 'store'])->name('course.store');
    Route::get('/course/edit/{encodedId}', [CourseController::class, 'edit'])->name('course.edit');
    Route::put('/course/{id}', [CourseController::class, 'update'])->name('course.update');
    Route::delete('/course/{id}', [CourseController::class, 'delete'])->name('course.delete');

    // ROTA PROFESSORES
    Route::get('/professor', [ProfessorController::class, 'index'])->name('professor.index');
    Route::get('/professor/create', [ProfessorController::class, 'create'])->name('professor.create');
    Route::post('/professor', [ProfessorController::class, 'store'])->name('professor.store');
    Route::get('/professor/edit/{encodedId}', [ProfessorController::class, 'edit'])->name('professor.edit');
    Route::put('/professor/{id}', [ProfessorController::class, 'update'])->name('professor.update');
    Route::delete('/professor/{id}', [ProfessorController::class, 'delete'])->name('professor.delete');
});

require __DIR__.'/auth.php';
