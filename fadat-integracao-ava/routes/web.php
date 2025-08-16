<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Professor\ProfessorController;
use App\Http\Controllers\Subject\SubjectController;
use App\Http\Controllers\Classroom\ClassroomController;
use App\Http\Controllers\Roomboking\RoombokingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\Professors;
use App\Models\Subject;
use App\Models\Roombooking;
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
    Route::get('/course', [CourseController::class, 'index'])->name('course.index')->can('viewAny', Course::class);
    Route::get('/course/create', [CourseController::class, 'create'])->name('course.create')->can('create', Course::class);
    Route::post('/course', [CourseController::class, 'store'])->name('course.store')->can('create', Course::class);
    Route::get('/course/edit/{encodedId}', [CourseController::class, 'edit'])->name('course.edit')->can('update', Course::class);
    Route::put('/course/{id}', [CourseController::class, 'update'])->name('course.update')->can('update', Course::class);
    Route::delete('/course/{id}', [CourseController::class, 'delete'])->name('course.delete')->can('delete', Course::class);

    // ROTA PROFESSORES
    Route::get('/professor', [ProfessorController::class, 'index'])->name('professor.index')->can('viewAny', Professors::class);
    Route::get('/professor/create', [ProfessorController::class, 'create'])->name('professor.create')->can('create', Professors::class);
    Route::post('/professor', [ProfessorController::class, 'store'])->name('professor.store')->can('create', Professors::class);
    Route::get('/professor/edit/{encodedId}', [ProfessorController::class, 'edit'])->name('professor.edit')->can('update', Professors::class);
    Route::put('/professor/{id}', [ProfessorController::class, 'update'])->name('professor.update')->can('update', Professors::class);
    Route::delete('/professor/{id}', [ProfessorController::class, 'delete'])->name('professor.delete')->can('delete', Professors::class);
    
    // ROTA DISCIPLINAS
    Route::get('/subject', [SubjectController::class, 'index'])->name('subject.index')->can('viewAny', Subject::class);
    Route::get('/subject/create', [SubjectController::class, 'create'])->name('subject.create')->can('create', Subject::class);
    Route::post('/subject', [SubjectController::class, 'store'])->name('subject.store')->can('create', Subject::class);
    Route::get('/subject/edit/{encodedId}', [SubjectController::class, 'edit'])->name('subject.edit')->can('update', Subject::class);
    Route::put('/subject/{id}', [SubjectController::class, 'update'])->name('subject.update')->can('update', Subject::class);
    Route::delete('/subject/{id}', [SubjectController::class, 'delete'])->name('subject.delete')->can('delete', Subject::class);

    // ROTA SALAS
    Route::get('/classroom', [ClassroomController::class, 'index'])->name('classroom.index')->can('viewAny', Classroom::class);
    Route::get('/classroom/create', [ClassroomController::class, 'create'])->name('classroom.create')->can('create', Classroom::class);
    Route::post('/classroom', [ClassroomController::class, 'store'])->name('classroom.store')->can('create', Classroom::class);
    Route::get('/classroom/edit/{encodedId}', [ClassroomController::class, 'edit'])->name('classroom.edit')->can('update', Classroom::class);
    Route::put('/classroom/{id}', [ClassroomController::class, 'update'])->name('classroom.update')->can('update', Classroom::class);
    Route::delete('/classroom/{id}', [ClassroomController::class, 'delete'])->name('classroom.delete')->can('delete', Classroom::class);

    // ROTA AGENDAMENTO DE SALAS
    Route::get('/roomboking', [RoombokingController::class, 'index'])->name('roomboking.index')->can('viewAny', Roombooking::class);
    Route::get('/roomboking/search', [RoombokingController::class, 'search'])->name('roomboking.search')->can('viewAny', Roombooking::class);
    Route::get('/roomboking/create', [RoombokingController::class, 'create'])->name('roomboking.create')->can('create', Roombooking::class);
    Route::post('/roomboking', [RoombokingController::class, 'store'])->name('roomboking.store')->can('create', Roombooking::class);
    Route::get('/roomboking/edit/{encodedId}', [RoombokingController::class, 'edit'])->name('roomboking.edit')->can('update', Roombooking::class);
    Route::put('/roomboking/{id}', [RoombokingController::class, 'update'])->name('roomboking.update')->can('update', Roombooking::class);
    Route::delete('/roomboking/{id}', [RoombokingController::class, 'delete'])->name('roomboking.delete')->can('delete', Roombooking::class);
});

require __DIR__.'/auth.php';
