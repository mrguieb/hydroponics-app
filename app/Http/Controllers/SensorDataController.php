<?php

// app/Http/Controllers/SensorDataController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;

class SensorDataController extends Controller
{
    public function store(Request $request)
    {
        $data = SensorData::create([
            'temperature' => $request->temperature,
            'humidity' => $request->humidity,
            'ldr_analog' => $request->ldr_analog,
            'ldr_digital' => $request->ldr_digital,
            'distance' => $request->distance,
        ]);

        return response()->json(['success' => true, 'data' => $data]);
    }
}

