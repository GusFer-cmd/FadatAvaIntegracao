<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Professor\StoreProfessorsRequest;
use App\Http\Requests\Professor\UpdateProfessorsRequest;
use App\Services\ProfessorService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ProfessorController extends Controller
{
    public function index(ProfessorService $professorService)
    {
        if (!Auth::check())
            return redirect()->route('home')->with("Não foi possível contiuar. Tente novamente"); 
        
        $professors = $professorService->getAll();

        return Inertia::render('Professor/Index', [
            'professors' => $professors,
        ]);
    }

    public function create(ProfessorService $professorService)
    {
        if (!Auth::check())
            return redirect()->route('home')->with("Não foi possível contiuar. Tente novamente"); 
        
        $professors = $professorService->getAll();

        return Inertia::render('Professor/Register', [
            'professors' => $professors
        ]);
    }

    public function store(ProfessorService $professorService, StoreProfessorsRequest $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email
        ];

        $professor = $professorService->create($data);
        Log::info('Professor criado com sucesso: ' . $professor->id . ' - ' . $professor->name);
        Log::info('Curso criado por: ' . Auth::id() . ' - ' . Auth::user()?->name);
        
        return redirect()->route('professor.index')->with('success', 'Curso criado com sucesso!');
    }

    public function edit(string $encodedId, ProfessorService $professorService)
    {
        $id = base64_decode($encodedId);

        $professor = $professorService->getById($id);

        return Inertia::render('Professor/Update', [
            'professor' => $professor,
        ]);
    }

    public function update(string $id, ProfessorService $professorService, UpdateProfessorsRequest $request)
    {
        $data = [
            'id' => $id,
            'name' => $request->name,
            'email' => $request->email
        ];

        $professor = $professorService->update($data);
        Log::info('Professor atualizado com sucesso: ' . $professor->id . ' - ' . $professor->name);
        Log::info('Professor atualizado por: ' . Auth::id() . ' - ' . Auth::user()?->name);
    
        return redirect()->route('professor.index')->with('success','Curso atualizado com sucesso');
    }

    public function delete(string $id, ProfessorService $professorService)
    {
        $professor = $professorService->getById($id);

        $professorService->delete($id);
        Log::info('Professor deletado com sucesso: ' . $professor->id . ' - ' . $professor->name);
        Log::info('Professor deletado por: ' . Auth::id() . ' - ' . Auth::user()?->name);
        
        return redirect()->route('professor.index')->with('success', 'Professor deletado com sucesso');
    }
}
