<?php

namespace App\Services;

use App\Exceptions\RoombookingNotFoundException;
use App\Exceptions\RoombookingConflictException;
use App\Exceptions\ProfessorConflictException;
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
        $conflicts = $this->repository->getConflictsByDayAndTime(
            $data['day_of_week'],
            $data['start_time'],
            $data['end_time'],
            $data['classroom_id'],
            $data['professor_id']
        );

        foreach ($conflicts as $conflict) {
            if ($conflict->classroom_id === $data['classroom_id']) {
                throw new RoombookingConflictException();
            }
            if ($conflict->professor_id === $data['professor_id']) {
                throw new ProfessorConflictException();
            }
        }

        return $this->repository->create($data);
    }

    public function getByProfessorId(string $professorId): Collection
    {
        $roombookings = $this->repository->getByProfessorId($professorId);

        if ($roombookings->isEmpty()) {
            throw new ProfessorNotFoundException();
        }

        return $roombookings;
    }

    public function getByClassroomId(string $classroomId): Collection
    {
        $roombookings = $this->repository->getByClassroomId($classroomId);

        if ($roombookings->isEmpty()) {
            throw new ClassroomNotFoundException();
        }

        return $roombookings;
    }

    public function getBySubjectId(string $subjectId): Collection
    {
        $roombookings = $this->repository->getBySubjectId($subjectId);

        if ($roombookings->isEmpty()) {
            throw new SubjectNotFoundException();
        }

        return $roombookings;
    }

    public function search(?string $searchTerm = ''): Collection
    {
        return $this->repository->search($searchTerm);
    }

    public function update(array $data): Roombooking
    {
        $roombooking = $this->repository->getById($data['id']);
        if ($roombooking === null) {
            throw new RoombookingNotFoundException();
        }

          $conflicts = $this->repository->getConflictsByDayAndTime(
            $data['day_of_week'], 
            $data['start_time'], 
            $data['end_time'], 
            $data['classroom_id'], 
            $data['professor_id'], 
            $data['id']
        );

        foreach ($conflicts as $conflict) {
            if ($conflict->classroom_id === $data['classroom_id']) {
                throw new RoombookingConflictException();
            }
            if ($conflict->professor_id === $data['professor_id']) {
                throw new ProfessorConflictException();
            }
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
