<?php

use Illuminate\Support\Str;

return [
    /*
    |--------------------------------------------------------------------------
    | Locations For The Weather API
    |--------------------------------------------------------------------------
    |
    | Here you may define you may define the locations
    | by defining the latitude and lat and longitude and lon of the locations
    | and supports only 2 locations.
    |
    */

    'locations' => [

        'location_1' => [
            'name' => 'Colombo',
            'lat' => 6.9271,
            'lon' => 79.8612,
        ],

        'location_2' => [
            'name' => 'Melbourne',
            'lat' => 37.8136,
            'lon' => 144.9631,
        ],

    ],

];
