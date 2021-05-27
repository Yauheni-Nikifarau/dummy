<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Weather extends Model
{
    /**
     * Returns 7-day weather forecast for given geolocation from cache or from weather API
     *
     * @param $lat - latitude
     * @param $lon - longitude
     * @return array|mixed
     */
    public static function getWeather ($lat, $lon)
    {
        $today = Carbon::today()->getTimestamp();

        $cacheKey = "{$today}_{$lat}_{$lon}";

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $response = self::getWeatherFromApi($lat, $lon);
        $data = self::transformWeatherData($response);
        Cache::put($cacheKey, $data);

        return $data;
    }

    /**
     * returns 7-day forecast for given geolocation from weather API
     *
     * @param $lat - latitude
     * @param $lon - longitude
     * @return array|mixed
     */
    private static function getWeatherFromApi ($lat, $lon)
    {
        $key = config('api.weatherKey');
        $response = Http::get("https://api.openweathermap.org/data/2.5/onecall?lat={$lat}&lon={$lon}&exclude=hourly,minutely&units=metric&appid={$key}");
        $response = $response->json();
        return $response;
    }

    /**
     * transform Weather API response data to necessary format
     *
     * @param $data
     * @return array
     */
    private static function transformWeatherData ($data)
    {
        $data = $data['daily'];
        $response = [];
        foreach ($data as $dayData) {
            $response[] = [
                'date' => Carbon::createFromTimestamp($dayData["dt"])->format('Y-m-d'),
                'weatherShort' => $dayData['weather'][0]['main'],
                'weatherFull' => $dayData['weather'][0]['description'],
                'pressure' => $dayData['pressure'],
                'dayTemperature' => $dayData['temp']['day'],
                'nightTemperature' => $dayData['temp']['night'],
                'eveningTemperature' => $dayData['temp']['eve'],
                'morningTemperature' => $dayData['temp']['morn'],
                'windSpeed' => $dayData['wind_speed']
            ];
        }
        return $response;
    }
}
