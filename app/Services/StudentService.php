<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;

class StudentService
{
    private Student $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function getAll(): Collection  {

        return $this->student
            ->where('status', "=", '1')
            ->get();
    }

    public function save(array $values): Student {
        return $this->student->create($values);
    }

    public function findById(int $id): ?Student {

        return $this->student
            ->where('id', "=", $id)
            ->where('status', "=", '1')
            ->first();
    }

    public function updateById(int $id, array $values): ?Student {
        $student = $this->findById($id);
        if ($student) {
            $student->update($values);
        }

        return $student;
    }

    public function destroy(int $id): ?bool
    {
        $student = $this->findById($id);
        if ($student) {
            return $student->delete();
        }

        return $student;
    }
}
