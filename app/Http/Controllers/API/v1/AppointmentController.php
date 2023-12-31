<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\AppointmentRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\API\v1\AppointmentResource;
use App\Http\Services\API\v1\AppointmentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    private $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    public function index(Request $request)
    {
        $appointments = $this->appointmentService->getAllAppointments($request);
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
        try {
            $appointment = $this->appointmentService->getAppointmentById($id);
            return new AppointmentResource($appointment);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }
    }

    public function update(AppointmentRequest $request, $id)
    {
        try {
            $appointment = $this->appointmentService->updateAppointment($request, $id);
            return new AppointmentResource($appointment);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->appointmentService->deleteAppointment($id);
            return response()->json(['message' => 'Appointment delete'], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }
    }

    public function freeHours(Request $request)
    {
        try {
            $freeHours = $this->appointmentService->freeHours($request);
            return response()->json(['freeHours' => $freeHours]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }
    }
}