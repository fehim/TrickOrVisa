<?php

namespace App\Services;

use App\Models\VisaRequirement;

class VisaService extends BaseService
{
    public function getVisaData($countryCode)
    {
        $visaData = VisaRequirement::where("from", $countryCode)
            ->orderBy('id', 'asc')
            ->get(["to", "type", "text", "info"]);

        #EF652C dark orange
        #FCA366 orange
        #5BCFD5 blue
        #1C97B5 dark blue

        $visaRequirements = [];
        $visaInfo = [];
        foreach ($visaData as $data) {
            // Color the map
            if ($data['type'] == "yes") {
                $visaRequirements[$data["to"]] = "#1C97B5";
            } else if ($data['type'] == "no") {
                $visaRequirements[$data["to"]] = "#FCA366";
            } else if ($data['type'] == "maybe") {
                $visaRequirements[$data["to"]] = "#5BCFD5";
            }

            // Get the extra data
            $visaInfo[$data["to"]] = [$data["text"], $data["info"]];
        }
        $visaRequirements[$countryCode] = "#FFF";

        return [
            'visaRequirements' => $visaRequirements,
            'visaInfo' => $visaInfo
        ];
    }
}
