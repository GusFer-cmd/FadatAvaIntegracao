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
use Carbon\Carbon;

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
        $start = Carbon::parse($data['start_date_time']);
        $end   = Carbon::parse($data['end_date_time']);

        $conflicts = $this->repository->getConflicts( $data['classroom_id'], $data['professor_id'], $start, $end);

        if ($conflicts->isNotEmpty()) {
            throw new RoombookingConflictException();
        }

        return $this->repository->create($data);
    }

    public function update(array $data): Roombooking
    {
        $roombooking = $this->repository->getById($data['id']);

        if ($roombooking === null) {
            throw new RoombookingNotFoundException();
        }

        $start = Carbon::parse($data['start_date_time']);
        $end   = Carbon::parse($data['end_date_time']);

        $conflicts = $this->repository->getConflicts( $data['classroom_id'], $data['professor_id'], $start, $end, $data['id']);

        if ($conflicts->isNotEmpty()) {
            throw new RoombookingConflictException();
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