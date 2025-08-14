<?php

namespace App\Repositories\Eloquent;

use App\Models\Subject;
use App\Repositories\Interfaces\ISubjectRepository;
use Illuminate\Support\Collection;

class SubjectRepository implements ISubjectRepository
{
    public function getAll(): Collection
    {
        return Subject::all();
    }

    public function getById(string $id): ?Subject
    {
        return Subject::find($id);
    }

    public function getByCourseId(string $courseId): Collection
    {
        return Subject::where('course_id', $courseId)->get();
    }

    public function create(array $data): Subject
    {
        return Subject::create($data);
    }

    public function exists(string $name): ?Subject
    {
        return Subject::where('name', $name)->first();
    }

    public function update(Subject &$subject, array $data): bool
    {
        return $subject->update($data);
    }

    public function delete(Subject $subject): ?bool
    {
        return $subject->delete();
    }
}