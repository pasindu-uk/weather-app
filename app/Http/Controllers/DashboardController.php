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
        //API triggering for location 1
        $location1MetricResponse = Http::get('https://api.openweathermap.org/data/2.5/onecall?lat='.config('api.locations.location_1.lat').'&lon='.config('api.locations.location_1.lon').'&exclude=hourly,daily,minutely&units=metric&appid=8dc9ba99c4e5fe28f4dc20edbc1848c0');
        $location1ImperialResponse = Http::get('https://api.openweathermap.org/data/2.5/onecall?lat='.config('api.locations.location_1.lat').'&lon='.config('api.locations.location_1.lon').'&exclude=hourly,daily,minutely&units=imperial&appid=8dc9ba99c4e5fe28f4dc20edbc1848c0');

        //API triggering for location 2
        $location2MetricResponse = Http::get('https://api.openweathermap.org/data/2.5/onecall?lat='.config('api.locations.location_2.lat').'&lon='.config('api.locations.location_2.lon').'&exclude=hourly,daily,minutely&units=metric&appid=8dc9ba99c4e5fe28f4dc20edbc1848c0');
        $location2ImperialResponse = Http::get('https://api.openweathermap.org/data/2.5/onecall?lat='.config('api.locations.location_2.lat').'&lon='.config('api.locations.location_2.lon').'&exclude=hourly,daily,minutely&units=imperial&appid=8dc9ba99c4e5fe28f4dc20edbc1848c0');

        //API data
        $data = [
            'location_1' => [
                'celsius' => $location1MetricResponse['current']['temp'],
                'fahrenheit' => $location1ImperialResponse['current']['temp'],
            ],
            'location_2' => [
                'celsius' => $location2MetricResponse['current']['temp'],
                'fahrenheit' => $location2ImperialResponse['current']['temp'],
            ],
        ];
        dd($data);
        return Inertia::render('Dashboard');
    }
}
