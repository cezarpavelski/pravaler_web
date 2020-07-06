<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstitutionRequest;
use App\Http\Resources\InstitutionResource;
use App\Services\InstitutionService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    private InstitutionService $institutionService;

    public function __construct(InstitutionService $institutionService)
    {
        $this->institutionService = $institutionService;
    }

    public function index()
    {
        return $this->institutionService->getAll();
    }

    public function store(Request $request)
    {
        $requestValidated = $this->validate($request, InstitutionRequest::rules());
        $newInstitution = $this->institutionService->save($requestValidated);

        return response()->json(
            new InstitutionResource($newInstitution),
            Response::HTTP_CREATED
        );
    }

    public function show(int $id)
    {
        $institution = $this->institutionService->findById($id);

        if (!$institution) {
            return response()->json(
                '404 - Not Found',
                Response::HTTP_NOT_FOUND
            );
        }

        return $institution;
    }

    public function update(Request $request, int $id)
    {
        $requestValidated = $this->validate($request, InstitutionRequest::rules());
        $institution = $this->institutionService->updateById($id, $requestValidated);

        if (!$institution) {
            return response()->json(
                '404 - Not Found',
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json(
            new InstitutionResource($institution),
            Response::HTTP_OK
        );
    }

    public function destroy(int $id)
    {
        return $this->institutionService->destroy($id);
    }
}
