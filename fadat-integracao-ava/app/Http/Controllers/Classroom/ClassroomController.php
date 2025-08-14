<?php

namespace App\Http\Controllers\Classroom;

use App\Http\Requests\ClassRoom\StoreClassroomRequest;
use App\Http\Requests\ClassRoom\UpdateClassroomRequest;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Services\ClassroomService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ClassroomController extends Controller
{
    public function index(ClassroomService $classroomService)
    {   
        if (!Auth::check())
            return redirect()->route('home')->with("Não foi possível contiuar. Tente novamente"); 
        
        $classrooms = $classroomService->getAll();

        return Inertia::render('Classroom/Index', [
            'classrooms' => $classrooms,
        ]);
    }

    public function create(ClassroomService $classroomService)
    {
        if (!Auth::check())
            return redirect()->route('home')->with("Não foi possível contiuar. Tente novamente"); 

        $classrooms = $classroomService->getAll();

        return Inertia::render('Classroom/Register', [
            'classrooms' => $classrooms,
        ]);
    }

    public function store(ClassroomService $classroomService, StoreClassroomRequest $request)
    {
        $data = [
            'class_number' => $request->class_number,
            'person_class' => $request->person_class,
            'academic_building' => $request->academic_building,
            'url' => $request->url
        ];

        $classroom = $classroomService->create($data);
        Log::info('Sala criada com sucesso: ' . $classroom->id . ' - ' . $classroom->class_number);
        Log::info('Sala criado por: ' . Auth::id() . ' - ' . Auth::user()?->name);
    
        return redirect()->route('classroom.index')->with('success', 'Sala criada com sucesso!');
    }

    public function edit(string $encodedId, ClassroomService $classroomService)
    {   
        $id = base64_decode($encodedId);

        $classroom = $classroomService->getById($id); 

        return Inertia::render('Classroom/Update', [
            'classroom' => $classroom,
        ]);
    }

    public function update(string $id, ClassroomService $classroomService, UpdateClassroomRequest $request)
    {
        $data = [
            'id' => $id,
            'class_number' => $request->class_number,
            'person_class' => $request->person_class,
            'academic_building' => $request->academic_building,
            'url' => $request->url
        ];

        $classroom = $classroomService->update($data);
        Log::info('Sala atualizada com sucesso: ' . $classroom->id . ' - ' . $classroom->class_number);
        Log::info('Sala atualizada por: ' . Auth::id() . ' - ' . Auth::user()?->name);

        return redirect()->route('classroom.index')->with('success','Sala atualizado com sucesso');
    }

    public function delete(string $id, ClassroomService $classroomService)
    {
        $classroom = $classroomService->getById($id);
        
        $classroomService->delete($id);
        Log::info('Sala deletado com sucesso: ' . $classroom->id . ' - ' . $classroom->class_number);
        Log::info('Sala deletado por: ' . Auth::id() . ' - ' . Auth::user()?->name);

        return redirect()->route('classroom.index')->with('success', 'Sala deletada com sucesso');
    }
}
