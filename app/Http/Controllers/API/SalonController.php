<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Salon;

class SalonController extends Controller
{
    public function index()
    {
        $salons = Salon::all();
        return response()->json($salons);
    }

    public function store(Request $request)
    {   
        $salon = Salon::create($request->all());
        return response()->json($salon, 201);
    }

    public function show($id)
    {
        $salon = Salon::findOrFail($id);
        return response()->json($salon);
    }

    public function update(Request $request, $id)
    {
        $salon = Salon::findOrFail($id);
        $salon->update($request->all());
        return response()->json($salon, 200);
    }

    public function destroy($id)
    {
        $salon = Salon::findOrFail($id);
        $salon->delete();
        return response()->json(['message' => 'Salon delete'], 204);
    }
}