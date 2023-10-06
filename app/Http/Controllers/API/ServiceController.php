<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Http\Requests\API\ServiceRequest;
use Illuminate\Validation\ValidationException;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return response()->json($services);
    }

    public function store(ServiceRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $service = Service::create($validatedData);
            return response()->json($service, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id)
    {
        $service = Service::findOrFail($id);
        return response()->json($service);
    }

    public function update(ServiceRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $service = Service::findOrFail($id);
            $service->update($validatedData);
            return response()->json($service, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return response()->json(['message' => 'Service delete'], 204);
    }
}