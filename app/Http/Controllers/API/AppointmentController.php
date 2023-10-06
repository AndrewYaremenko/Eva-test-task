<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Http\Requests\API\AppointmentRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\API\AppointmentResource;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::orderBy('appointment_date', 'desc')->get();
        return AppointmentResource::collection($appointments);
    }

    public function store(AppointmentRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $appointment = Appointment::create($validatedData);
            return (new AppointmentResource($appointment))
            ->response()
            ->setStatusCode(201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);
        return new AppointmentResource($appointment); 
    }

    public function update(AppointmentRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $appointment = Appointment::findOrFail($id);
            $appointment->update($validatedData);
            return new AppointmentResource($appointment);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return response()->json(['message' => 'Appointment delete'], 204);
    }
}