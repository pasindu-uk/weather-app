<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;
use App\Models\Temperature;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        //API triggering for location 1
        $location1MetricResponse = Http::get('https://api.openweathermap.org/data/2.5/onecall?lat='.config('api.locations.location_1.lat').'&lon='.config('api.locations.location_1.lon').'&exclude=hourly,daily,minutely&units=metric&appid='.env('OPEN_WEATHER_KEY'));
        $location1ImperialResponse = Http::get('https://api.openweathermap.org/data/2.5/onecall?lat='.config('api.locations.location_1.lat').'&lon='.config('api.locations.location_1.lon').'&exclude=hourly,daily,minutely&units=imperial&appid='.env('OPEN_WEATHER_KEY'));

        //API triggering for location 2
        $location2MetricResponse = Http::get('https://api.openweathermap.org/data/2.5/onecall?lat='.config('api.locations.location_2.lat').'&lon='.config('api.locations.location_2.lon').'&exclude=hourly,daily,minutely&units=metric&appid='.env('OPEN_WEATHER_KEY'));
        $location2ImperialResponse = Http::get('https://api.openweathermap.org/data/2.5/onecall?lat='.config('api.locations.location_2.lat').'&lon='.config('api.locations.location_2.lon').'&exclude=hourly,daily,minutely&units=imperial&appid='.env('OPEN_WEATHER_KEY'));

        $temperature = Temperature::whereBetween('timestamp',[now()->startOfDay(), now()->endOfDay()])->first();

        if ($temperature == null) {
            $temperature = Temperature::create([
                'timestamp' => now(),
                'location' => 1,
                'celsius' => $location1MetricResponse['current']['temp'],
                'fahrenheit' => $location1ImperialResponse['current']['temp'],
            ]);
            $temperature = Temperature::create([
                'timestamp' => now(),
                'location' => 2,
                'celsius' => $location2MetricResponse['current']['temp'],
                'fahrenheit' => $location2ImperialResponse['current']['temp'],
            ]);
        } else {
            $temperature = Temperature::whereBetween('timestamp',[now()->startOfDay(), now()->endOfDay()])->where('location',1)->first();
            if ($temperature->celsius != (float)round($location1MetricResponse['current']['temp'],2)) {
                $temperature->update([
                    'timestamp' => now(),
                    'celsius' => $location1MetricResponse['current']['temp'],
                    'fahrenheit' => $location1ImperialResponse['current']['temp'],
                ]);
            }
            $temperature = Temperature::whereBetween('timestamp',[now()->startOfDay(), now()->endOfDay()])->where('location',2)->first();
            if ($temperature->celsius_2 != (float)round($location2MetricResponse['current']['temp'],2)) {
                $temperature->update([
                    'timestamp' => now(),
                    'celsius' => $location2MetricResponse['current']['temp'],
                    'fahrenheit' => $location2ImperialResponse['current']['temp'],
                ]);
            }
        }
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('email')).'|'.$this->ip();
    }
}
