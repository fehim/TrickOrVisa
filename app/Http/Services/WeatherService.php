<?php

namespace App\Services;

use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;

class WeatherService extends BaseService
{
    public function getCurrentWeather($location)
    {
        // Language of data (try your own language here!):
        //$lang = 'en';

        // Units (can be 'metric' or 'imperial' [default]):
        $units = 'metric';

        // Create OpenWeatherMap object.
        $owm = new OpenWeatherMap(env("WEATHER_API"));

        try {
            $weather = $owm->getWeather($location, $units);
            return [
                'temp' => round($weather->temperature->now->getValue()),
                'unit' => $weather->temperature->now->getUnit(),
                'desc' => ucwords($weather->weather->description)
            ];
        } catch(OWMException $e) {
            echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
        } catch(\Exception $e) {
            echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
        }

        return null;
    }
}
