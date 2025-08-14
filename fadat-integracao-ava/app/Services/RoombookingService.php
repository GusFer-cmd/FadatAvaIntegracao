<?php

namespace App\Services;

use App\Exceptions\RoombookingNotFoundException;
use App\Exceptions\RoombookingConflictException;
use App\Exceptions\ProfessorNotFoundException;
use App\Exceptions\SubjectNotFoundException;
use App\Exceptions\ClassroomNotFoundException;
use App\Models\Roombooking;
use App\Repositories\Interfaces\IRoombookingRepository;
use Illuminate\Support\Collection;

class RoombookingService
{
    private IRoombookingRepository $repository;

    public function __construct(IRoombookingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    public function getById(string $id): ?Roombooking
    {
        $roombooking = $this->repository->getById($id);
        if ($roombooking === null) {
            throw new RoombookingNotFoundException();
        }

        return $roombooking;
    }

    public function create(array $data): Roombooking
    {
        return $this->repository->create($data);
    }

    public function exists(array $data, ?string $excludeId = null): ?Roombooking
    {
        return $this->repository->exists($data, $excludeId);
    }

    public function update(array $data): Roombooking
    {
        $roombooking = $this->repository->getById($data['id']);
        if ($roombooking === null) {
            throw new RoombookingNotFoundException();
        }

        $this->repository->update($roombooking, $data);
        
        return $roombooking;
    }
    
    public function delete(string $id): ?bool
    {
        $roombooking = $this->repository->getById($id);
        if ($roombooking === null) {
            throw new RoombookingNotFoundException();
        }

        return $this->repository->delete($roombooking);
    }
}