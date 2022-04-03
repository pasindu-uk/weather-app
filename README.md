# Weather App

An web application created to store the current temperatures of two cities defined by the users and display historical data on an interactive dashboard

## Installation

Clone the project.

Run ``` composer install ```

Rename .env.example file to .env or run cp .env.example .env.

Update .env to your specific needs. Don't forget to set DB_USERNAME and DB_PASSWORD with the settings used behind.

Run ``` php artisan key:generate. ```

Run ``` php artisan migrate --seed.```

## Using NPM

``` npm install ```

``` npm run dev ``` or ``` npm run prod ```

## Changing API Parameters
On the config folder open the api.php file. The structure is
``` bash 
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
```

You can amend the parameters as per your requirement.

##Known Issue
The applications only starts login temperatures on login. During registration process the procedure was amended to stop the automatic login and redirect user back to login screen due to time constraints  until a solution is found.

## License
[MIT](https://choosealicense.com/licenses/mit/)
