<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Location;
use App\Services\VisaService;
use App\Services\WikipediaScraperService;
use Illuminate\Http\JsonResponse;


/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends BaseController
{
    public function index(VisaService $visaService, $countryCode = "TR")
    {
        $location = Location::get();
        if ($location->error === true || $location->countryCode === "RD") {
            $location = (object) [
                'countryCode' => 'US',
                'countryName' => 'United States'
            ];
        }

        $data = $visaService->getVisaData($location);
        return view('home.home', $data);
    }

    public function detail()
    {
        return view('detail.detail');
    }

    public function chat()
    {
        return view('home.chat');
    }

    public function scrape(WikipediaScraperService $scraperService)
    {
        $scraperService->scrapeVisaData();
    }

    public function changeCountry(VisaService $visaService, $country)
    {
        $data = $visaService->getVisaData($country);

        return new JsonResponse($data);
    }
}
