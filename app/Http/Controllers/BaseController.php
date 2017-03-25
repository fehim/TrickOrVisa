<?php

namespace App\Http\Controllers;

use Location;

class BaseController extends Controller
{
    public function hydrateResponse($data)
    {
        $response = [];

        if (is_object($data)) {
            $data = json_decode(json_encode($data), true);
        }

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $response[camel_case($key)] = $this->hydrateResponse($value);
            } else {
                $response[camel_case($key)] = $value;
            }
        }

        return $response;
    }

    public function getLocation()
    {
        $location = Location::get();
        if ($location->error === true || $location->countryCode === "RD") {
            $location = (object) [
                'countryCode' => 'US',
                'countryName' => 'United States'
            ];
        }

        return $location;
    }
}