<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Models\WeatherRecord; // ✅ added

Route::get('/weather/current', function () {

    $city = request('city');
    $apiKey = env('OPENWEATHER_API_KEY');

    $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
        'q' => $city,
        'units' => 'metric',
        'appid' => $apiKey
    ]);

    $data = $response->json();

    // ✅ ADDED: Save to database
    if ($response->successful() && isset($data['main'])) {
        WeatherRecord::create([
            'city' => $city,
            'data' => $data
        ]);
    }

    return $data;
});


Route::get('/weather/forecast', function () {

    $city = request('city');
    $apiKey = env('OPENWEATHER_API_KEY');

    $response = Http::get("https://api.openweathermap.org/data/2.5/forecast", [
        'q' => $city,
        'units' => 'metric',
        'appid' => $apiKey
    ]);

    return $response->json();
});

Route::get('/weather', [WeatherController::class, 'getWeather']);
Route::get('/forecast', [WeatherController::class, 'getForecast']);