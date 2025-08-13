<?php

namespace App\Repositories\Eloquent;

use App\Models\Professors;
use App\Repositories\Interfaces\IProfessorRepository;
use Illuminate\Support\Collection;

class ProfessorRepository implements IProfessorRepository
{
    public function getAll(): Collection
    {
        return Professors::all();
    }

    public function getById(string $id): ?Professors
    {
        return Professors::find($id);
    }

    public function exists(string $name): ?Professors
    {
        return Professors::where('name', $name)
        ->first();
    }

    public function create(array $data): Professors
    {
        return Professors::create($data);
    }

    public function update(Professors &$professor, array $data): bool
    {
        return $professor->update($data);
    }

    public function delete(Professors $professor): ?bool
    {
        return $professor->delete();
    }
}