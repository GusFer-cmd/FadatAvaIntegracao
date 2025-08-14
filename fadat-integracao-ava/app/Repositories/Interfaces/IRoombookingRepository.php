<?php 

namespace App\Repositories\Interfaces;

use App\Models\Roombooking;
use Illuminate\Support\Collection;

interface IRoombookingRepository
{
    public function getAll(): Collection;
    public function getById(string $id): ?Roombooking;
    public function create(array $data): Roombooking;
    public function exists(array $data, ?string $excludeId = null): ?Roombooking;
    public function getByProfessorId(string $professorId): Collection;
    public function getByClassroomId(string $classroomId): Collection;
    public function getBySubjectId(string $subjectId): Collection;
    public function getByDateRange(string $startDate, string $endDate): Collection;
    public function update(Roombooking &$roombooking, array $data): bool;
    public function delete(Roombooking $roombooking): ?bool;
}