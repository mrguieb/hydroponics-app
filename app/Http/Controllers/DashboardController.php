<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;

class DashboardController extends Controller
{
    // Load dashboard with initial data
    public function index()
    {
        $data = SensorData::latest()->take(3)->get(); // show last 10 records
        return view('dashboard', compact('data'));
    }

    // AJAX method to return latest sensor data view
    public function getLatestData()
    {
        $data = SensorData::latest()->take(3)->get();
        return view('partials.sensor-data', compact('data'));
    }
}


