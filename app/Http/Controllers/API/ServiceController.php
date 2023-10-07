<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ServiceRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\API\ServiceResource;
use App\Http\Services\API\ServiceService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ServiceController extends Controller
{
    private $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function index()
    {
        $services = $this->serviceService->getAllServices();
        return ServiceResource::collection($services);
    }

    public function store(ServiceRequest $request)
    {
        try {
            $service = $this->serviceService->createService($request);
            return (new ServiceResource($service))
                ->response()
                ->setStatusCode(201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id)
    {
        try {
            $service = $this->serviceService->getServiceById($id);
            return new ServiceResource($service);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Service not found'], 404);
        }
    }

    public function update(ServiceRequest $request, $id)
    {
        try {
            $service = $this->serviceService->updateService($request, $id);
            return new ServiceResource($service);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Service not found'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->serviceService->deleteService($id);
            return response()->json(['message' => 'Service delete'], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Service not found'], 404);
        }
    }
}