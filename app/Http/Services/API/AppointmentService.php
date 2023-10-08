<?php

namespace App\Http\Services\API;

use App\Models\Appointment;
use App\Http\Requests\API\AppointmentRequest;
use Illuminate\Http\Request;

class AppointmentService
{
    public function getAllAppointments(Request $request)
    {

        $sort = $request->input('sort');
        $query = Appointment::query();

        if ($sort) {
            if ($sort === 'asc') {
                $query->orderBy('date', 'asc');
            } elseif ($sort === 'desc') {
                $query->orderBy('date', 'desc');
            } elseif ($sort === 'service') {
                $query->orderBy('service_id');
            }
        } else {
            $query->orderBy('date', 'desc');
        }

        $appointments = $query->get();
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

    public function freeHours(Request $request)
    {
        $date = $request->query('date');
        $id = $request->query('id');
        $freeHours = Appointment::getFreeHoursForService($date, $id);
        return $freeHours;
    }
}