<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;

class DashboardController extends Controller
{
    public function index()
    {
        $data = SensorData::latest()->take(10)->get(); // show last 10 records
        return view('dashboard', compact('data'));
    }
}

