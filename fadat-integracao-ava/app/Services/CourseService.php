<?php

namespace App\Services;

use App\Exceptions\CourseNotFoundException;
use App\Models\Course;
use App\Repositories\Interfaces\ICourseRepository;
use Illuminate\Support\Collection;

class CourseService
{
    private ICourseRepository $repository;

    public function __construct(ICourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    public function getById(string $id): ?Course
    {
        $course = $this->repository->getById($id);
        if ($course === null)
            throw new CourseNotFoundException();

        return $course;
    }

    public function create(array $data): Course
    {
        $exists = $this->repository->exists($data['name']);
        if ($exists)
            throw new CourseNotFoundException();

        $course = $this->repository->create($data);

        return $course;
    }

    public function update(array $data): Course
    {
        $course = $this->repository->getById($data['id']);

        $this->repository->update($course, $data);
        
        return $course;
    }
    
    public function delete(string $id)
    {
        $course = $this->repository->getById($id);
        if ($course === null)
            throw new CourseNotFoundException();

        return $this->repository->delete($course);
    }
}