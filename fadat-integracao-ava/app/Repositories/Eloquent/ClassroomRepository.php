<?php

namespace App\Repositories\Eloquent;

use App\Models\Classroom;
use App\Repositories\Interfaces\IClassRoomRepository;
use Illuminate\Support\Collection;

class ClassroomRepository implements IClassRoomRepository
{
    public function getAll(): Collection
    {
        return Classroom::all();
    }

    public function getById(string $id): ?Classroom
    {
        return Classroom::find($id);
    }

    public function create(array $data): Classroom
    {
        return Classroom::create($data);
    }

    public function exists(int $class_number, ?string $academic_building): ?Classroom
    {
        return Classroom::where('class_number', $class_number)
            ->where('academic_building', $academic_building)
            ->first();
    }

    public function update(Classroom &$classroom, array $data): bool
    {
        return $classroom->update($data);
    }

    public function delete(Classroom $classroom): ?bool
    {
        return $classroom->delete();
    }
}