<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

class CourseService
{
    private Course $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function getAll(): Collection  {

        return $this->course
            ->with('students')
            ->where('status', "=", 1)
            ->get();
    }

    public function save(array $values): Course {
        return $this->course->create($values);
    }

    public function findById(int $id): ?Course {

        return $this->course
            ->with('students')
            ->where('id', "=", $id)
            ->where('status', "=", '1')
            ->first();
    }

    public function updateById(int $id, array $values): ?Course {
        $course = $this->findById($id);
        if ($course) {
            $course->update($values);
        }

        return $course;
    }

    public function destroy(int $id): ?bool
    {
        $course = $this->findById($id);
        if ($course) {
            return $course->delete();
        }

        return $course;
    }
}
