<?php

namespace App\Http\Services\API;

use App\Models\Appointment;
use App\Http\Requests\API\AppointmentRequest;

class AppointmentService
{
    public function getAllAppointments()
    {
        $appointments = Appointment::orderBy('appointment_date', 'desc')->get();
        return $appointments;
    }

    public function createAppointment(AppointmentRequest $request)
    {
        $validatedData = $request->validated();
        $appointment = Appointment::create($validatedData);
        return $appointment;
    }

    public function getAppointmentById($id)
    {
        $appointment = Appointment::findOrFail($id);
        return $appointment;
    }

    public function updateAppointment(AppointmentRequest $request, $id)
    {
        $validatedData = $request->validated();
        $appointment = Appointment::findOrFail($id);
        $appointment->update($validatedData);
        return $appointment;
    }

    public function deleteAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
    }
}