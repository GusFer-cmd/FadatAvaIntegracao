<?php

namespace App\Services;

use App\Exceptions\SubjectNotFoundException;
use App\Exceptions\SubjectAlreadyCreatedException;
use App\Exceptions\CourseNotFoundException;
use App\Models\Subject;
use App\Repositories\Interfaces\ISubjectRepository;
use Illuminate\Support\Collection;

class SubjectService
{
    private ISubjectRepository $repository;

    public function __construct(ISubjectRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    public function getById(string $id): ?Subject
    {
        $subject = $this->repository->getById($id);
        if ($subject === null)
            throw new SubjectNotFoundException();

        return $subject;
    }

    public function getByCourseId(string $courseId): Collection
    {
        $course = $this->repository->getByCourseId($courseId);
        if ($course->isEmpty())
            throw new CourseNotFoundException();

        return $course;
    }

    public function create(array $data): Subject
    {
        $exists = $this->repository->exists($data['name']);
        if ($exists)
            throw new SubjectAlreadyCreatedException();

        return $this->repository->create($data);
    }

    public function update(array $data): Subject
    {
        $subject = $this->repository->getById($data['id']);
        if ($subject === null)
            throw new SubjectNotFoundException();

        $this->repository->update($subject, $data);
        
        return $subject;
    }
    
    public function delete(string $id): ?bool
    {
        $subject = $this->repository->getById($id);
        if ($subject === null)
            throw new SubjectNotFoundException();

        return $this->repository->delete($subject);
    }
}