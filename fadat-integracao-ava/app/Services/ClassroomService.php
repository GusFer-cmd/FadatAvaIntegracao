<?php

namespace App\Services;

use App\Exceptions\ClassroomAlreadyCreated;
use App\Exceptions\ClassroomNotFoundException;
use App\Models\Classroom;
use App\Repositories\Interfaces\IClassroomRepository;
use Illuminate\Support\Collection;

class ClassroomService
{
    private IClassroomRepository $repository;

    public function __construct(IClassroomRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    public function getById(string $id): ?Classroom
    {
        $classroom = $this->repository->getById($id);
        if ($classroom === null)
            throw new ClassroomNotFoundException();

        return $classroom;
    }

    public function create(array $data): Classroom
    {
        $exists = $this->repository->exists($data['class_number'], $data['academic_building']);
        if ($exists)
            throw new ClassroomAlreadyCreated();

        $classroom = $this->repository->create($data);

        return $classroom;
    }

    public function update(array $data): Classroom
    {
        $classroom = $this->repository->getById($data['id']);

        $this->repository->update($classroom, $data);
        
        return $classroom;
    }

    public function delete(string $id)
    {
        $classroom = $this->repository->getById($id);
        if ($classroom === null)
            throw new ClassroomNotFoundException();

        return $this->repository->delete($classroom);
    }
}