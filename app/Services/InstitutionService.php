<?php

namespace App\Services;

use App\Models\Institution;
use Illuminate\Database\Eloquent\Collection;

class InstitutionService
{
    private Institution $institution;

    public function __construct(Institution $institution)
    {
        $this->institution = $institution;
    }

    public function getAll(): Collection  {

        return $this->institution
            ->with('courses')
            ->where('status', "=", '1')
            ->get();
    }

    public function save(array $values): Institution {
        return $this->institution->create($values);
    }

    public function findById(int $id): ?Institution {

        return $this->institution
            ->with('courses')
            ->where('id', "=", $id)
            ->where('status', "=", '1')
            ->first();
    }

    public function updateById(int $id, array $values): ?Institution {
        $institution = $this->findById($id);
        if ($institution) {
            $institution->update($values);
        }

        return $institution;
    }

    public function destroy(int $id): ?bool
    {
        $institution = $this->findById($id);
        if ($institution) {
            return $institution->delete();
        }

        return $institution;
    }
}
