<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\SalonRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\API\SalonResource;
use App\Http\Services\API\SalonService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SalonController extends Controller
{
    private $salonService;

    public function __construct(SalonService $salonService)
    {
        $this->salonService = $salonService;
    }

    public function index()
    {
        $salons = $this->salonService->getAllSalons();
        return SalonResource::collection($salons);
    }

    public function store(SalonRequest $request)
    {
        try {
            $salon = $this->salonService->createSalon($request);
            return (new SalonResource($salon))
                ->response()
                ->setStatusCode(201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id)
    {
        try {
            $salon = $this->salonService->getSalonById($id);
            return new SalonResource($salon);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Salon not found'], 404);
        }
    }

    public function update(SalonRequest $request, $id)
    {
        try {
            $salon = $this->salonService->updateSalon($request, $id);
            return (new SalonResource($salon))
                ->response()
                ->setStatusCode(201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Salon not found'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->salonService->deleteSalon($id);
            return response()->json(['message' => 'Salon delete'], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Salon not found'], 404);
        }
    }
}