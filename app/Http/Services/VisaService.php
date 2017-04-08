<?php

namespace App\Services;

use App\Models\Country;
use App\Models\VisaRequirement;

class VisaService extends BaseService
{
    public function getVisaData($from, $countries)
    {
        foreach ($countries as $country) {
            $countryCodes[$country->name] = $country->code;
        }

        $visaData = VisaRequirement::where("from", $from)
            ->orderBy('id', 'asc')
            ->get(["to", "from", "type", "text", "info", "to_name"]);


        $visaRequirements = [];
        $visaInfo = [];
        foreach ($visaData as $data) {
            // Color the map
            if ($data['type'] == "yes") {
                $visaRequirements[$data["to"]] = config('map.colors.yes');
            } else if ($data['type'] == "no") {
                $visaRequirements[$data["to"]] = config('map.colors.no');
            } else if ($data['type'] == "maybe") {
                $visaRequirements[$data["to"]] = config('map.colors.maybe');
            }
            // Get the extra data
            $visaInfo[$data["to"]] = [$data["text"], $data["info"]];
            $from = $data["from"];
        }

        if (isset($visaInfo["DK"])) {
            //Greenland is not a country but a denmark territory
            $visaRequirements["GL"] = $visaRequirements["DK"];
            $visaInfo["GL"] = $visaInfo["DK"];
        }

        $visaRequirements[$from] = config('map.colors.from');
        return [
            'visaRequirements' => $visaRequirements,
            'visaInfo' => $visaInfo,
            'currentLocation' => $from
        ];
    }
}
