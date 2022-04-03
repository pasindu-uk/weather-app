<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $response = Http::get('https://api.openweathermap.org/data/2.5/onecall?lat=6.9271&lon=79.8612&exclude=hourly,daily,minutely&units=metric&appid=8dc9ba99c4e5fe28f4dc20edbc1848c0');
        dd($response->json($key = null));
        return Inertia::render('Dashboard');
    }
}
