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
        $countryData = Country::orderBy("id", "desc")
            ->whereNotNull("visa_link")
            ->get(["code", "name", "visa_link"]);
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
                            foreach ($td->childNodes as $node) {
                                if ($node->nodeName == "a") {
                                    $country['to_name'] = $node->textContent;
                                    $country['to'] = $this->getCountryCode($country['to_name'], $countryCodes);
                                }
                            }
                        } else if ($key == 2) {
                            $canGo = $td->getAttribute('class');
                            switch ($canGo) {
                                case "table-yes";
                                case "table-yes2";
                                case "free table-free";
                                    $type = "yes";
                                    break;
                                case "partial table-partial":
                                    $type = "maybe";
                                    break;
                                default:
                                    $type = "no";
                            }
                            $country['type'] = $type;
                            foreach ($td->childNodes as $node) {
                                if($node->nodeName == "sup") {
                                    // @todo get the cite note link from wikipedia
                                } else {
                                    $country['text'] = $node->textContent;
                                }
                            }
                        } else if ($key == 4) {
                            foreach ($td->childNodes as $node) {
                                if($node->nodeName == "sup") {
                                    // @todo get the cite note link from wikipedia
                                } else {
                                    $country['info'] = $node->textContent;
                                }
                            }
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

    public function scrapeCountryData()
    {
        $countryData = Country::orderBy("id", "desc")
            ->whereNotNull("link")
            ->get(["code", "name", "link"]);

        $client = new Client();
        $wikipediaUrl = "http://en.wikipedia.org";
        foreach ($countryData as $key => $country) {
            $crawler = $client->request('GET', $wikipediaUrl.$country->link);//."/wiki/Romania");
            $rows = $crawler->filter(".vcard")->first()->filter("tr");

            $rows = $rows->getIterator();
            //$rows->
            //var_dump($rows);exit;
            $details = [];
            foreach ($rows as $rowNumber => $row) {
                $text = $row->textContent;
                if (stristr($text, "capital") and stristr($text, "largest")) {
                    $details['capital'] = $this->getText($text, 2);
                    $details['largest'] = null;
                } else if (stristr($text, "capital")) {
                    $details['capital'] = $this->getText($text);
                } else
                if (stristr($text, "largest")) {
                    $details['largest'] = $this->getText($text);
                }

                if (stristr($text, "languages")) {
                    $languages = explode("\n", $text);
                    foreach ($languages as $language) {
                        $language = $this->stripBullshit($language);
                        if (!empty($language) and stristr($language, "language") === false) {
                            $details['language'][] = $language;
                        }
                    }
                }

                if (stristr($text, "population")) {
                    var_dump($rows[$rowNumber+1]);
                }

                continue;

                //area
                //population
                //currency
                //timezone
            }

            $countryDetails[$country->code] = $details;
            if ($key == 2)
                break;
        }

        var_dump($countryDetails);exit;
    }

    public function getText($text, $offset = 1)
    {
        $text = explode("\n", $text)[$offset];

        // Clean from brackets
        $text = $this->stripBullshit($text);

        // Clean from numbers
        preg_match('/^\D*(?=\d)/', $text, $m);
        $offset = isset($m[0]) ? strlen($m[0]) : false;
        if ($offset) {
            $text = substr($text, 0, $offset);
        }

        return $text;
    }

    public function stripBullshit($text)
    {
        $patterns = [
            '[^"]', //quotes
            '/\[[^\[\]]*\]/', //brackets
            '/\([^)]+\)/', // parentheses
        ];

        return preg_replace($patterns, '', $text);
    }

    public function getCountryCode($name, $codes)
    {
        $name = str_ireplace(" and territories", "", $name);

        if ($name == "Cote d'Ivoire ! Côte d'Ivoire" ||
            $name == "Côte d'Ivoire" ||
            $name == "Cote d'Ivoire" ||
            $name == "Ivory Coast ! Ivory Coast"
        ) {
            $name = "Cote d'Ivoire (Ivory Coast)";
        }

        if ($name == "São Tomé and Príncipe") {
            $name = "Sao Tome and Principe";
        }

        if (stristr($name, "United Kingdom")) {
            $name = "United Kingdom";
        }

        if ($name == "United States of America") {
            $name = "United States";
        }

        if (stristr($name, "Burma")) {
            $name = "Myanmar";
        }

        if (stristr($name, "Netherlands")) {
            $name = "Netherlands";
        }

        if ($name == "Australia and external territories") {
            $name = "Australia";
        }

        if(isset($codes[$name])) {
            return $codes[$name];
        } else {
            return null;
        }
    }
}
