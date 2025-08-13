<?php 

namespace App\Repositories\Interfaces;

use App\Models\Professors;
use Illuminate\Support\Collection;

interface IProfessorRepository
{
    public function getAll(): Collection;
    public function getById(string $id): ?Professors;
    public function create(array $data): Professors;
    public function exists(string $name): ?Professors;
    public function update(Professors &$professor, array $data): bool;
    public function delete(Professors $professor): ?bool;
}