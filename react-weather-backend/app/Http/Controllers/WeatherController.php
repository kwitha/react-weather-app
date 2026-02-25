<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\WeatherRecord;

class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
        $city = $request->query('city');
        $apiKey = env('OPENWEATHER_API_KEY');

        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'q' => $city,
            'units' => 'metric',
            'appid' => $apiKey,
        ]);

        $data = $response->json();

        if (isset($data['cod']) && $data['cod'] == 200) {
            WeatherRecord::create([
                'city' => $city,
                'data' => $data,
            ]);
        }

        return $data;
    }

    public function getForecast(Request $request)
    {
        $city = $request->query('city');
        $apiKey = env('OPENWEATHER_API_KEY');

        $response = Http::get("https://api.openweathermap.org/data/2.5/forecast", [
            'q' => $city,
            'units' => 'metric',
            'appid' => $apiKey,
        ]);

        return $response->json();
    }

    public function records()
    {
        return WeatherRecord::latest()->get();
    }
}