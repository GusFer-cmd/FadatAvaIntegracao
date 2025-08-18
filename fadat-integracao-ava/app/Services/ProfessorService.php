<?php

namespace App\Services;

use App\Exceptions\ProfessorAlreadyCreated;
use App\Exceptions\ProfessorNotFoundException;
use App\Models\Professors;
use App\Repositories\Interfaces\IProfessorRepository;
use Illuminate\Support\Collection;

class ProfessorService
{
    private IProfessorRepository $repository;

    public function __construct(IProfessorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    public function getById(string $id): ?Professors
    {
        $professor = $this->repository->getById($id);
        if ($professor === null)
            throw new ProfessorNotFoundException();

        return $professor;
    }

    public function create(array $data): Professors
    {
        $exists = $this->repository->exists($data['name']);
        if ($exists)
            throw new ProfessorAlreadyCreated();

        $professor = $this->repository->create($data);

        return $professor;
    }

    public function update(array $data): Professors
    {
        $professor = $this->repository->getById($data['id']);

        $this->repository->update($professor, $data);
        
        return $professor;
    }
    
    public function delete(string $id)
    {
        $professor = $this->repository->getById($id);
        if ($professor === null)
            throw new ProfessorNotFoundException();

        return $this->repository->delete($professor);
    }
}