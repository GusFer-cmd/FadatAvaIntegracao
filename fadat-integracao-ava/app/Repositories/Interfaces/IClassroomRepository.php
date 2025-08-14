<?php 

namespace App\Repositories\Interfaces;

use App\Models\Classroom;
use Illuminate\Support\Collection;

interface IClassroomRepository
{
    public function getAll(): Collection;
    public function getById(string $id): ?Classroom;
    public function create(array $data): Classroom;
    public function exists(int $class_number, ?string $academic_building): ?Classroom;
    public function update(Classroom &$classroom, array $data): bool;
    public function delete(Classroom $classroom): ?bool;
}