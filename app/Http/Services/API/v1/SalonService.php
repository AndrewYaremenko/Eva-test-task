<?php

namespace App\Http\Services\API\v1;

use App\Models\Salon;
use App\Http\Requests\API\v1\SalonRequest;

class SalonService
{
    public function getAllSalons()
    {
        $salons = Salon::all();
        return $salons;
    }

    public function createSalon(SalonRequest $request)
    {
        $validatedData = $request->validated();
        $salon = Salon::create($validatedData);
        return $salon;
    }

    public function getSalonById($id)
    {
        $salon = Salon::findOrFail($id);
        return $salon;
    }

    public function updateSalon(SalonRequest $request, $id)
    {
        $validatedData = $request->validated();
        $salon = Salon::findOrFail($id);
        $salon->update($validatedData);
        return $salon;
    }

    public function deleteSalon($id)
    {
        $salon = Salon::findOrFail($id);
        $salon->delete();
    }
}