<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CountryDetail;
use App\Services\WeatherService;

use App\Services\VisaService;
use App\Services\WikipediaScraperService;
use Illuminate\Http\JsonResponse;


/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends BaseController
{
    public function index(VisaService $visaService)
    {
        $location = $this->getLocation();

        $countries = Country::orderBy("name", "asc")
            ->get([
                "slug",
                "code",
                "name"
            ]);

        $combo = [];
        $countryInfo = [];
        foreach ($countries as $country) {
            $combo[] = $country->name;
            $countryInfo[$country->code] = [
                "slug" => $country->slug,
            ];
        }

        $data = $visaService->getVisaData($location, $countries);

        $data['countries'] = $combo;
        $data['countryInfo'] = $countryInfo;
        return view('home.home', $data);
    }

    public function detail(WeatherService $weatherService, $to, $from = null)
    {
        $to = Country::where("slug", $to)
            ->first();

        $to_details = CountryDetail::where("country_code", $to->code)
            ->get()->toArray();

        foreach ($to_details as $to_detail) {
            $details[$to_detail['type']][] = $to_detail['value'];
        }

        if (empty($from)) {
            $location = $this->getLocation();
            $from = str_slug($location->countryName);
        }

        $weather = $weatherService->getCurrentWeather($to->capital.','.$to->code);

        $from = Country::where("slug", $from)
                ->first();

        return view('detail.detail',
            [
                'to' => $to,
                'details' =>$details,
                'from' => $from,
                'weather' => $weather
            ]
        );
    }

    public function chat(WikipediaScraperService $scraper)
    {
        $test = $scraper->scrapeCountryData();
        exit;

        return view('home.chat');
    }

    public function changeCountry(VisaService $visaService, $country)
    {
        $data = $visaService->getVisaData($country);

        return new JsonResponse($data);
    }

    public function contact()
    {
        return view('home.contact');
    }

    public function getCapitalSetSlug()
    {
        $allCountries = json_decode(file_get_contents("https://restcountries.eu/rest/v1/all"), true);

        foreach ($allCountries as $country) {
            $update = [
                'region' => $country['region'],
                'subregion' => $country['subregion'],
                'capital' => $country['capital'],
                'population' => $country['population'],
                'area' => $country['area'],
                'gini' => $country['gini']
            ];

            Country::where("code", $country['alpha2Code'])
                ->update($update);

            $details = [];
            if (!empty($country['timezones'])) {
                foreach ($country['timezones'] as $timezone) {
                    $details[] = [
                        'country_code' => $country['alpha2Code'],
                        'type' => 'timezone',
                        'value' => $timezone
                    ];
                }
            }

            if (!empty($country['borders'])) {
                foreach ($country['borders'] as $border) {
                    $details[] = [
                        'country_code' => $country['alpha2Code'],
                        'type' => 'border',
                        'value' => $border
                    ];
                }
            }

            if (!empty($country['currencies'])) {
                foreach ($country['currencies'] as $currency) {
                    $details[] = [
                        'country_code' => $country['alpha2Code'],
                        'type' => 'currency',
                        'value' => $currency
                    ];
                }
            }

            if (!empty($country['languages'])) {
                foreach ($country['languages'] as $language) {
                    $details[] = [
                        'country_code' => $country['alpha2Code'],
                        'type' => 'language',
                        'value' => $language
                    ];
                }
            }

            CountryDetail::insert($details);
        }
        var_dump($allCountries);exit;
    }
}
