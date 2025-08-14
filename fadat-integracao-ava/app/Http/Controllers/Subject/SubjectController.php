<?php

namespace App\Http\Controllers\Subject;

use App\Http\Requests\Subject\StoreSubjectRequest;
use App\Http\Requests\Subject\UpdateSubjectRequest;
use App\Http\Controllers\Controller;
use App\Services\SubjectService;
use App\Services\CourseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class SubjectController extends Controller
{
    public function index(SubjectService $subjectService)
    {
        if (!Auth::check())
            return redirect()->route('home')->with("Não foi possível continuar. Tente novamente");

        $subjects = $subjectService->getAll();

        return Inertia::render('Subject/Index', [
            'subjects' => $subjects,
        ]);
    }

    public function create(SubjectService $subjectService, CourseService $courseService)
    {
        if (!Auth::check())
            return redirect()->route('home')->with("Não foi possível continuar. Tente novamente");

        $courses = $courseService->getAll();

        return Inertia::render('Subject/Register', [
            'courses' => $courses,
        ]);
    }

    public function store(StoreSubjectRequest $request, SubjectService $subjectService)
    {
        $data = [
            'name' => $request->name,
            'semester' => $request->semester,
            'course_id' => $request->course_id,
        ];

        $subject = $subjectService->create($data);
        Log::info('Disciplina criada com sucesso: ' . $subject->id . ' - ' . $subject->name);
        Log::info('Disciplina criada por: ' . Auth::id() . ' - ' . Auth::user()?->name);

        return redirect()->route('subject.index')->with('success', 'Disciplina criada com sucesso!');
    }

    public function edit(string $encodedId, SubjectService $subjectService, CourseService $courseService)
    {
        $id = base64_decode($encodedId);
        
        $subject = $subjectService->getById($id);
        $courses = $courseService->getAll();

        return Inertia::render('Subject/Update', [
            'subject' => $subject,
            'courses' => $courses,
        ]);
    }

    public function update(string $id, UpdateSubjectRequest $request, SubjectService $subjectService)
    {
        $data = [
            'id' => $id,
            'name' => $request->name,
            'semester' => $request->semester,
            'course_id' => $request->course_id,
        ];

        $subject = $subjectService->update($data);
        Log::info('Disciplina atualizada com sucesso: ' . $subject->id . ' - ' . $subject->name);
        Log::info('Disciplina atualizada por: ' . Auth::id() . ' - ' . Auth::user()?->name);

        return redirect()->route('subject.index')->with('success', 'Disciplina atualizada com sucesso!');
    }

    public function delete(string $id, SubjectService $subjectService)
    {
        $subject = $subjectService->getById($id);

        $subjectService->delete($id);
        Log::info('Disciplina deletada com sucesso: ' . $subject->id . ' - ' . $subject->name);
        Log::info('Disciplina deletado por: ' . Auth::id() . ' - ' . Auth::user()?->name);

        return redirect()->route('subject.index')->with('success', 'Disciplina deletada com sucesso!');
    }
}
