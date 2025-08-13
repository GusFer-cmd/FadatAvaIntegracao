<?php

namespace App\Repositories\Eloquent;

use App\Models\Course;
use App\Repositories\Interfaces\ICourseRepository;
use illuminate\Support\Collection;

class CourseRepository implements ICourseRepository
{
    public function getAll(): Collection
    {
        return Course::all();
    }

    public function getById(string $id): ?Course
    {
        return Course::find($id);
    }

    public function exists(string $name): ?Course
    {
        return Course::where('name', $name)
            ->first();
    }

    public function create(array $data): Course
    {
        return Course::create($data);
    }

    public function update(Course &$course, array $data): bool
    {
        return $course->update($data);
    }

    public function delete(Course $course): ?bool
    {
        return $course->delete();
    }
}