<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Http\Requests\API\AppointmentRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\API\AppointmentResource;
use App\Services\API\AppointmentService;

class AppointmentController extends Controller
{
    private $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    public function index()
    {
        $appointments = $this->appointmentService->getAllAppointments();
        return AppointmentResource::collection($appointments);
    }

    public function store(AppointmentRequest $request)
    {
        try {
            $appointment = $this->appointmentService->createAppointment($request);
            return (new AppointmentResource($appointment))
                ->response()
                ->setStatusCode(201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id)
    {
        $appointment = $this->appointmentService->getAppointmentById($id);
        return new AppointmentResource($appointment); 
    }

    public function update(AppointmentRequest $request, $id)
    {
        try {
            $appointment = $this->appointmentService->updateAppointment($request, $id);
            return new AppointmentResource($appointment);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id)
    {
        $this->appointmentService->deleteAppointment($id);
        return response()->json(['message' => 'Appointment delete'], 204);
    }
}