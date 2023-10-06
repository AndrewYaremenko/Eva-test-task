<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Salon;
use App\Http\Requests\API\SalonRequest;
use Illuminate\Validation\ValidationException;

class SalonController extends Controller
{
    public function index()
    {
        $salons = Salon::all();
        return response()->json($salons);
    }

    public function store(SalonRequest $request)
    {   
        try {
            $validatedData = $request->validated();
            $salon = Salon::create($validatedData);
            return response()->json($salon, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id)
    {
        $salon = Salon::findOrFail($id);
        return response()->json($salon);
    }

    public function update(SalonRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $salon = Salon::findOrFail($id);
            $salon->update($validatedData);
            return response()->json($salon, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id)
    {
        $salon = Salon::findOrFail($id);
        $salon->delete();
        return response()->json(['message' => 'Salon delete'], 204);
    }
}