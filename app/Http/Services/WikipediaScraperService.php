<?php

namespace App\Services;

use App\Models\VisaRequirement;
use App\Models\Country;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use DB;

class WikipediaScraperService extends BaseService
{
    public function scrapeVisaData()
    {
        DB::table('visa_requirements')->truncate();
        $countryData = Country::orderBy("id", "desc")->get(["code", "name", "visa_link"]);
        $client = new Client();

        $countryCodes = [];
        foreach ($countryData as $country) {
            $countryCodes[$country["name"]] = $country["code"];
        }


        foreach ($countryData as $countryRow) {
            $crawler = $client->request('GET', $countryRow['visa_link']);
            $visaRequirements = [];

            //go through all the rows of the first wikitable
            $visaRows = $crawler->filter('.wikitable.sortable')->first()->filter("tr");
            foreach ($visaRows as $row) {
                $country = [
                    'to_name' => '',
                    'type' => '',
                    'text' => '',
                    'info' => ''
                ];

                foreach ($row->childNodes as $key => $td) {
                    if ($td->nodeName == "td") {
                        // country name
                        if ($key == 0) {
                            $country['to_name'] = preg_replace('/^\p{Z}+|\p{Z}+$/u', '', $td->textContent);
                            $country['to'] = $this->getCountryCode($country['to_name'], $countryCodes);
                        } else if ($key == 2) {
                            $canGo = $td->getAttribute('class');
                            switch ($canGo) {
                                case "table-yes";
                                case "table-yes2";
                                case "free table-free";
                                    $type = "yes";
                                    break;
                                case "table-no":
                                    $type = "no";
                                    break;
                                default:
                                    $type = "maybe";
                            }
                            $country['type'] = $type;
                            $country['text'] = $td->textContent;
                        } else if ($key == 4) {
                            $country['info'] = $td->textContent ? $td->textContent : "";
                        }
                    }
                }
                if (!empty($country['type'])) {
                    $country["from"] = $countryRow["code"];
                    $visaRequirements[] = $country;
                }
            }
            VisaRequirement::insert($visaRequirements);
        }
    }

    public function getCountryCode($name, $codes)
    {
        if ($name == 'Australia and territories') {
            $name = 'Australia';
        }

        if ($name == "Cote d'Ivoire ! Côte d'Ivoire") {
            $name = "Cote d'Ivoire (Ivory Coast)";
        }

        if ($name == "New Zealand and territories") {
            $name = "New Zealand";
        }

        if ($name == "São Tomé and Príncipe") {
            $name = "Sao Tome and Principe";
        }

        if ($name == "United States and territories") {
            $name = "United States";
        }

        if (stristr($name, "United Kingdom")) {
            $name = "United Kingdom";
        }

        if(isset($codes[$name])) {
            return $codes[$name];
        } else {
            return null;
        }
    }
}
