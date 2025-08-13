<?php 

namespace App\Repositories\Interfaces;

use App\Models\Course;
use Illuminate\Support\Collection;

interface ICourseRepository
{
    public function getAll(): Collection;
    public function getById(string $id): ?Course;
    public function exists(string $name): ?Course;
    public function update(Course &$course, array $data): bool;
    public function delete(Course $course): ?bool;
}