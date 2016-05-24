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
        }
        $visaRequirements[$countryCode] = "#6DAD88";

        return [
            'visaRequirements' => $visaRequirements,
            'visaInfo' => $visaInfo
        ];
    }
}
