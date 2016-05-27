<?php

namespace App\Services;

use App\Models\Country;
use App\Models\VisaRequirement;

class VisaService extends BaseService
{
    public function getVisaData($location)
    {
        $countryData = Country::orderBy("name", "asc")->get(["name", "code"]);

        $countries = [];
        foreach ($countryData as $country) {
            $countries[] = $country->name;
            $countryCodes[$country->name] = $country->code;
        }

        if (is_object($location)) {
            $from = $location->countryCode;
        } else {
            $from = isset($countryCodes[$location]) ? $countryCodes[$location] : "US";
        }

        $visaData = VisaRequirement::where("from", $from)
            ->orderBy('id', 'asc')
            ->get(["to", "from", "type", "text", "info", "to_name"]);


        $visaRequirements = [];
        $visaInfo = [];
        foreach ($visaData as $data) {
            // Color the map
            if ($data['type'] == "yes") {
                $visaRequirements[$data["to"]] = "#9CC08A";
            } else if ($data['type'] == "no") {
                $visaRequirements[$data["to"]] = "#FCA366";
            } else if ($data['type'] == "maybe") {
                $visaRequirements[$data["to"]] = "#E6B072";
            }
            // Get the extra data
            $visaInfo[$data["to"]] = [$data["text"], $data["info"]];
            $from = $data["from"];
        }

        $visaRequirements[$from] = "#6DAD88";

        return [
            'visaRequirements' => $visaRequirements,
            'visaInfo' => $visaInfo,
            'countries' => $countries,
            'currentLocation' => $location
        ];
    }
}
