<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Http\Resources\StudentResource;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StudentController extends Controller
{
    private StudentService $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function index()
    {
        return $this->studentService->getAll();
    }

    public function store(Request $request)
    {
        $requestValidated = $this->validate($request, StudentRequest::rules());
        $newStudent = $this->studentService->save($requestValidated);

        return response()->json(
            new StudentResource($newStudent),
            Response::HTTP_CREATED
        );
    }

    public function show(int $id)
    {
        $student = $this->studentService->findById($id);

        if (!$student) {
            return response()->json(
                '404 - Not Found',
                Response::HTTP_NOT_FOUND
            );
        }

        return $student;
    }

    public function update(Request $request, int $id)
    {
        $requestValidated = $this->validate($request, StudentRequest::rules());
        $student = $this->studentService->updateById($id, $requestValidated);

        if (!$student) {
            return response()->json(
                '404 - Not Found',
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json(
            new StudentResource($student),
            Response::HTTP_OK
        );
    }

    public function destroy(int $id)
    {
        return $this->studentService->destroy($id);
    }
}
