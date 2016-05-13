<?php

namespace App\Http\Controllers;

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
}