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
        return Roombooking::with(['classroom', 'professor', 'subject', 'course'])->get();
    }

    public function getById(string $id): ?Roombooking
    {
        return Roombooking::find($id);
    }

    public function create(array $data): Roombooking
    {
        return Roombooking::create($data);
    }

    public function getConflicts(string $classroomId, string $professorId, Carbon $start, Carbon $end, ?string $excludeId = null): Collection
    {
        $query = Roombooking::query();

        $query->where(function ($q) use ($classroomId, $start, $end) {
            $q->where('classroom_id', $classroomId)
            ->whereHas('classroom', function ($q2) {
                $q2->whereIn('person_class', ['PR', 'ED']);
            })
            ->where('start_date_time', '<', $end)
            ->where('end_date_time', '>', $start);
        });

        $query->orWhere(function ($q) use ($professorId, $start, $end) {
            $q->where('professor_id', $professorId)
            ->where('start_date_time', '<', $end)
            ->where('end_date_time', '>', $start);
        });

        if ($excludeId) {
            $query->where('id', '<>', $excludeId);
        }

        return $query->get();
    }


    public function getByProfessorId(string $professorId): Collection
    {
        return Roombooking::with(['classroom', 'professor'])
            ->where('professor_id', $professorId)
            ->get();
    }

    public function getByClassroomId(string $classroomId): Collection
    {
        return Roombooking::with(['classroom', 'professor'])
            ->where('classroom_id', $classroomId)
            ->get();
    }

    public function getBySubjectId(string $subjectId): Collection
    {
        return Roombooking::with(['classroom', 'professor'])
            ->where('subject_id', $subjectId)
            ->get();
    }

    public function search(?string $searchTerm = ''): Collection
    {
    return Roombooking::with(['classroom', 'professor', 'subject.course'])
        ->whereHas('professor', function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        })
        ->orWhereHas('subject', function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhereHas('course', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%');
                });
        })
        ->get();
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