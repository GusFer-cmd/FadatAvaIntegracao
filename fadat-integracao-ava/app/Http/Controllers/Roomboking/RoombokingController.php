<?php

namespace App\Http\Controllers\Roomboking;

use App\Http\Requests\Roomboking\StoreRoombokingRequest;
use App\Http\Requests\Roomboking\UpdateRoombokingRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\RoombookingService;
use App\Services\ProfessorService;
use App\Services\SubjectService;
use App\Services\ClassroomService;
use App\Services\CourseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class RoombokingController extends Controller
{
    public function index(RoombookingService $roombookingService, CourseService $courseService)
    {
        if (!Auth::check())
            return redirect()->route('home')->with("Não foi possível contiuar. Tente novamente");

        $roombookings = $roombookingService->getAll();
        $courses = $courseService->getAll();

        return Inertia::render('Roomboking/Index', [
            'roombookings' => $roombookings,
            'courses' => $courses,
        ]);
    }

    public function search(Request $request, RoombookingService $roombookingService, CourseService $courseService)
    {
        if (!Auth::check())
            return redirect()->route('home')->with("Não foi possível contiuar. Tente novamente");

        $searchTerm = $request->input('search', '');
        $courses = $courseService->getAll();
        $roombookings = $roombookingService->search($searchTerm);

        return Inertia::render('Roomboking/Index', [
            'roombookings' => $roombookings,
            'courses' => $courses,
        ]);
    }

    public function create(RoombookingService $roombookingService, ProfessorService $professorService, SubjectService $subjectService, ClassroomService $classroomService)
    {
        if (!Auth::check())
            return redirect()->route('home')->with("Não foi possível contiuar. Tente novamente");

        $professors = $professorService->getAll();
        $subjects = $subjectService->getAll();
        $classrooms = $classroomService->getAll();

        return Inertia::render('Roomboking/Register', [
            'professors' => $professors,
            'subjects' => $subjects,
            'classrooms' => $classrooms,
        ]);
    }

    public function store(RoombookingService $roombookingService, StoreRoombokingRequest $request)
    {
        $data = [
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'professor_id' => $request->professor_id,
            'subject_id' => $request->subject_id,
            'classroom_id' => $request->classroom_id,
        ];

        $roombooking = $roombookingService->create($data);
        
        Log::info('Agendamento de sala criado com sucesso: ' . $roombooking->id);
        Log::info('Criado por: ' . Auth::id() . ' - ' . Auth::user()?->name);

        return redirect()->route('roomboking.index')->with('success', 'Agendamento de sala criado com sucesso!');
    }

    public function edit(string $encodedId, RoombookingService $roombookingService, ProfessorService $professorService, SubjectService $subjectService, ClassroomService $classroomService)
    {
        $id = base64_decode($encodedId);
        $roombooking = $roombookingService->getById($id);
        $professors = $professorService->getAll();
        $subjects = $subjectService->getAll();
        $classrooms = $classroomService->getAll();

        return Inertia::render('Roomboking/Update', [
            'roombooking' => $roombooking,
            'professors' => $professors,
            'subjects' => $subjects,
            'classrooms' => $classrooms,
        ]);
    }

    public function update(string $id, UpdateRoombokingRequest $request, RoombookingService $roombookingService)
    {
        $data = [
            'id' => $id,
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'professor_id' => $request->professor_id,
            'subject_id' => $request->subject_id,
            'classroom_id' => $request->classroom_id,
        ];

        $roombooking = $roombookingService->update($data);

        Log::info('Agendamento de sala atualizado com sucesso: ' . $roombooking->id);
        Log::info('Atualizado por: ' . Auth::id() . ' - ' . Auth::user()?->name);

        return redirect()->route('roomboking.index')->with('success', 'Agendamento de sala atualizado com sucesso!');
    }

    public function delete(string $id, RoombookingService $roombookingService)
    {
        $roombookingService->delete($id);

        Log::info('Agendamento de sala excluído: ' . $id);
        Log::info('Excluído por: ' . Auth::id() . ' - ' . Auth::user()?->name);

        return redirect()->route('roomboking.index')->with('success', 'Agendamento de sala excluído com sucesso!');
    }
}