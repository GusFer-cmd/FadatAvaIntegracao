<?php

namespace App\Http\Controllers\Course;

use App\Http\Requests\Course\CourseRequest;
use App\Http\Controllers\Controller;
use App\Services\CourseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function index(CourseService $courseService)
    {   
        if (!Auth::check())
            return redirect()->route('pages.home')->with("Não foi possível contiuar. Tente novamente"); 
        
         $courses = $courseService->getAll();

        return Inertia::render('Course/Index', [
            'courses' => $courses,
        ]);
    }

    public function create(CourseService $courseService)
    {
        if (!Auth::check())
            return redirect()->route('pages.home')->with("Não foi possível contiuar. Tente novamente"); 

        $courses = $courseService->getAll();

        return Inertia::render('Course/Register', [
            'courses' => $courses,
        ]);
    }

    public function store(CourseService $courseService, CourseRequest $request)
    {
        $data = [
            'name' => $request->name,
        ];

        $course = $courseService->create($data);
        Log::info('Curso criado com sucesso: ' . $course->id . ' - ' . $course->name);
        Log::info('Curso criado por: ' . Auth::id() . ' - ' . Auth::user()?->name);
    
        return redirect()->route('courses.index')->with('success', 'Curso criado com sucesso!');
    }
    
    public function edit(int $id, CourseService $courseService)
    {
        $course = $courseService->getById($id);

        return Inertia::render('Course/Edit', [
            'course' => $course,
        ]);
    }

    public function update(int $id, CourseService $courseService, CourseRequest $request)
    {
        $data = [
            'name' => $request->name,
        ];

        $course = $courseService->update($data);
        Log::info('Curso atualizado com sucesso: ' . $course->id . ' - ' . $course->name);
        Log::info('Curso atualizado por: ' . Auth::id() . ' - ' . Auth::user()?->name);

        return redirect()->route('course.index')->with('success','Curso atualizado com sucesso');
    }

    public function destroy(int $id, CourseService $courseService)
    {
        $course = $courseService->getById($id);
        
        $courseService->delete($id);
        Log::info('Curso deletado com sucesso: ' . $course->id . ' - ' . $course->name);
        Log::info('Curso deletado por: ' . Auth::id() . ' - ' . Auth::user()?->name);

        return redirect()->route('course.index')->with('success', 'Curso deletado com sucesso');
    }
}