<?php 

namespace App\Repositories\Interfaces;

use App\Models\Roombooking;
use Illuminate\Support\Collection;
use Carbon\Carbon;

interface IRoombookingRepository
{
    public function getAll(): Collection;
    public function getById(string $id): ?Roombooking;
    public function create(array $data): Roombooking;
    public function getConflicts( string $classroomId, string $professorId, Carbon $start, Carbon $end, ?string $excludeId = null): Collection;
    public function getByProfessorId(string $professorId): Collection;
    public function getByClassroomId(string $classroomId): Collection;
    public function getBySubjectId(string $subjectId): Collection;
    public function getByDateRange(string $startDate, string $endDate): Collection;
    public function update(Roombooking &$roombooking, array $data): bool;
    public function delete(Roombooking $roombooking): ?bool;
}