<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Temperature;
use App\Http\Resources\ApiResource;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return Inertia::render('Dashboard');
    }

    /**
     * Return api data.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function api()
    {
        if (request()->order == "") {
            $temperatures1 = Temperature::where('location',1)->orderBy('timestamp',"DESC")->get();
            $temperatures2 = Temperature::where('location',2)->orderBy('timestamp',"DESC")->get();
        } else {
            $temperatures1 = Temperature::where('location',1)->orderBy('celsius',"DESC")->get();
            $temperatures2 = Temperature::where('location',2)->orderBy('celsius',"DESC")->get();
        }
        return new ApiResource([
            'tableheaders' => [
                'locationOne' => config('api.locations.location_1.name'),
                'locationTwo' => config('api.locations.location_2.name'),
            ],
            'tabledata' => [
                'locationOne' => $temperatures1,
                'locationTwo' => $temperatures2,
            ],
        ]);
    }
}
