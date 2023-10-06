<?php

namespace App\Services\API;

use App\Models\Service;
use App\Http\Requests\API\ServiceRequest;
use Illuminate\Validation\ValidationException;

class ServiceService
{
    public function getAllServices()
    {
        $services = Service::all();
        return $services;
    }

    public function createService(ServiceRequest $request)
    {
        $validatedData = $request->validated();
        $service = Service::create($validatedData);
        return $service;
    }

    public function getServiceById($id)
    {
        $service = Service::findOrFail($id);
        return $service;
    }

    public function updateService(ServiceRequest $request, $id)
    {
        $validatedData = $request->validated();
        $service = Service::findOrFail($id);
        $service->update($validatedData);
        return $service;
    }

    public function deleteService($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
    }
}