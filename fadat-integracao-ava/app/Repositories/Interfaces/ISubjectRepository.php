<?php 

namespace App\Repositories\Interfaces;

use App\Models\Subject;
use Illuminate\Support\Collection;

interface ISubjectRepository
{
    public function getAll(): Collection;
    public function getById(string $id): ?Subject;
    public function getByCourseId(string $courseId): Collection;
    public function create(array $data): Subject;
    public function exists(string $name): ?Subject;
    public function update(Subject &$subject, array $data): bool;
    public function delete(Subject $subject): ?bool;
}