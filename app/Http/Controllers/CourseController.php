<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Services\CourseService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourseController extends Controller
{
    private CourseService $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index()
    {
        return $this->courseService->getAll();
    }

    public function store(Request $request)
    {
        $requestValidated = $this->validate($request, CourseRequest::rules());
        $newCourse = $this->courseService->save($requestValidated);

        return response()->json(
            new CourseResource($newCourse),
            Response::HTTP_CREATED
        );
    }

    public function show(int $id)
    {
        $course = $this->courseService->findById($id);

        if (!$course) {
            return response()->json(
                '404 - Not Found',
                Response::HTTP_NOT_FOUND
            );
        }

        return $course;
    }

    public function update(Request $request, int $id)
    {
        $requestValidated = $this->validate($request, CourseRequest::rules());
        $course = $this->courseService->updateById($id, $requestValidated);

        if (!$course) {
            return response()->json(
                '404 - Not Found',
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json(
            new CourseResource($course),
            Response::HTTP_OK
        );
    }

    public function destroy(int $id)
    {
        return $this->courseService->destroy($id);
    }
}
