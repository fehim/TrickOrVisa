<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\VisaRequirement;
use App\Services\VisaService;
use App\Services\WikipediaScraperService;
use Illuminate\Auth\Guard;
use Illuminate\Container\Container;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Symfony\Component\CssSelector\Node;
use DOMElement;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends BaseController
{
    public function index(VisaService $visaService, $countryCode = "TR")
    {
        $data = $visaService->getVisaData($countryCode);
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

    public function changeCountry(VisaService $visaService, $countryCode)
    {
        $data = $visaService->getVisaData($countryCode);

        return new JsonResponse($data);
    }
}
