<?php

namespace App\Repositories\Eloquent;

use Carbon\Carbon;
use App\Models\Roombooking;
use App\Repositories\Interfaces\IRoombookingRepository;
use Illuminate\Support\Collection;

class RoombookingRepository implements IRoombookingRepository
{
    public function getAll(): Collection
    {
        return Roombooking::all();
    }

    public function getById(string $id): ?Roombooking
    {
        return Roombooking::find($id);
    }

    public function create(array $data): Roombooking
    {
        return Roombooking::create($data);
    }

    public function exists(array $data, ?string $excludeId = null): ?Roombooking
    {
        $start = Carbon::parse($data['start_date_time']);
        $end = Carbon::parse($data['end_date_time']);

        $query = Roombooking::query();

        $conflictPeriod = function($q, $column, $value) use ($start, $end) {
            $q->where($column, $value)
            ->where(function($q2) use ($start, $end) {
                $q2->where(function($q3) use ($start, $end) {
                    $q3->where('start_date_time', '<', $end)
                        ->where('end_date_time', '>', $start);
                });
            });
        };

        $conflictPeriod($query, 'classroom_id', $data['classroom_id']);

        $query->orWhere(function($q) use ($conflictPeriod, $data) {
            $conflictPeriod($q, 'professor_id', $data['professor_id']);
        });

        if ($excludeId) {
            $query->where('id', '<>', $excludeId);
        }

        return $query->first();
    }

    public function getByProfessorId(string $professorId): Collection
    {
        return Roombooking::where('professor_id', $professorId)->get();
    }

    public function getByClassroomId(string $classroomId): Collection
    {
        return Roombooking::where('classroom_id', $classroomId)->get();
    }

    public function getBySubjectId(string $subjectId): Collection
    {
        return Roombooking::where('subject_id', $subjectId)->get();
    }

    public function getByDateRange(string $startDate, string $endDate): Collection
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        return Roombooking::where('start_date_time', '<', $end)
            ->where('end_date_time', '>', $start)
            ->get();
    }


    public function update(Roombooking &$roombooking, array $data): bool
    {
        return $roombooking->update($data);
    }

    public function delete(Roombooking $roombooking): ?bool
    {
        return $roombooking->delete();
    }
}