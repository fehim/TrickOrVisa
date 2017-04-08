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
        $languages = $this->getLanguages();

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
                'weather' => $weather,
                'languages' => $languages
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
        $countries = Country::orderBy("name", "asc")
            ->get([
                "slug",
                "code",
                "name"
            ]);
        $data = $visaService->getVisaData($country, $countries);

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

    public function getLanguages() 
    {
        return array(
            'aa' => 'Afar',
            'ab' => 'Abkhaz',
            'ae' => 'Avestan',
            'af' => 'Afrikaans',
            'ak' => 'Akan',
            'am' => 'Amharic',
            'an' => 'Aragonese',
            'ar' => 'Arabic',
            'as' => 'Assamese',
            'av' => 'Avaric',
            'ay' => 'Aymara',
            'az' => 'Azerbaijani',
            'ba' => 'Bashkir',
            'be' => 'Belarusian',
            'bg' => 'Bulgarian',
            'bh' => 'Bihari',
            'bi' => 'Bislama',
            'bm' => 'Bambara',
            'bn' => 'Bengali',
            'bo' => 'Tibetan Standard, Tibetan, Central',
            'br' => 'Breton',
            'bs' => 'Bosnian',
            'ca' => 'Catalan; Valencian',
            'ce' => 'Chechen',
            'ch' => 'Chamorro',
            'co' => 'Corsican',
            'cr' => 'Cree',
            'cs' => 'Czech',
            'cu' => 'Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic',
            'cv' => 'Chuvash',
            'cy' => 'Welsh',
            'da' => 'Danish',
            'de' => 'German',
            'dv' => 'Divehi; Dhivehi; Maldivian;',
            'dz' => 'Dzongkha',
            'ee' => 'Ewe',
            'el' => 'Greek, Modern',
            'en' => 'English',
            'eo' => 'Esperanto',
            'es' => 'Spanish; Castilian',
            'et' => 'Estonian',
            'eu' => 'Basque',
            'fa' => 'Persian',
            'ff' => 'Fula; Fulah; Pulaar; Pular',
            'fi' => 'Finnish',
            'fj' => 'Fijian',
            'fo' => 'Faroese',
            'fr' => 'French',
            'fy' => 'Western Frisian',
            'ga' => 'Irish',
            'gd' => 'Scottish Gaelic; Gaelic',
            'gl' => 'Galician',
            'gn' => 'GuaranÃ­',
            'gu' => 'Gujarati',
            'gv' => 'Manx',
            'ha' => 'Hausa',
            'he' => 'Hebrew (modern)',
            'hi' => 'Hindi',
            'ho' => 'Hiri Motu',
            'hr' => 'Croatian',
            'ht' => 'Haitian; Haitian Creole',
            'hu' => 'Hungarian',
            'hy' => 'Armenian',
            'hz' => 'Herero',
            'ia' => 'Interlingua',
            'id' => 'Indonesian',
            'ie' => 'Interlingue',
            'ig' => 'Igbo',
            'ii' => 'Nuosu',
            'ik' => 'Inupiaq',
            'io' => 'Ido',
            'is' => 'Icelandic',
            'it' => 'Italian',
            'iu' => 'Inuktitut',
            'ja' => 'Japanese (ja)',
            'jv' => 'Javanese (jv)',
            'ka' => 'Georgian',
            'kg' => 'Kongo',
            'ki' => 'Kikuyu, Gikuyu',
            'kj' => 'Kwanyama, Kuanyama',
            'kk' => 'Kazakh',
            'kl' => 'Kalaallisut, Greenlandic',
            'km' => 'Khmer',
            'kn' => 'Kannada',
            'ko' => 'Korean',
            'kr' => 'Kanuri',
            'ks' => 'Kashmiri',
            'ku' => 'Kurdish',
            'kv' => 'Komi',
            'kw' => 'Cornish',
            'ky' => 'Kirghiz, Kyrgyz',
            'la' => 'Latin',
            'lb' => 'Luxembourgish, Letzeburgesch',
            'lg' => 'Luganda',
            'li' => 'Limburgish, Limburgan, Limburger',
            'ln' => 'Lingala',
            'lo' => 'Lao',
            'lt' => 'Lithuanian',
            'lu' => 'Luba-Katanga',
            'lv' => 'Latvian',
            'mg' => 'Malagasy',
            'mh' => 'Marshallese',
            'mi' => 'Maori',
            'mk' => 'Macedonian',
            'ml' => 'Malayalam',
            'mn' => 'Mongolian',
            'mr' => 'Marathi (Mara?hi)',
            'ms' => 'Malay',
            'mt' => 'Maltese',
            'my' => 'Burmese',
            'na' => 'Nauru',
            'nb' => 'Norwegian BokmÃ¥l',
            'nd' => 'North Ndebele',
            'ne' => 'Nepali',
            'ng' => 'Ndonga',
            'nl' => 'Dutch',
            'nn' => 'Norwegian Nynorsk',
            'no' => 'Norwegian',
            'nr' => 'South Ndebele',
            'nv' => 'Navajo, Navaho',
            'ny' => 'Chichewa; Chewa; Nyanja',
            'oc' => 'Occitan',
            'oj' => 'Ojibwe, Ojibwa',
            'om' => 'Oromo',
            'or' => 'Oriya',
            'os' => 'Ossetian, Ossetic',
            'pa' => 'Panjabi, Punjabi',
            'pi' => 'Pali',
            'pl' => 'Polish',
            'ps' => 'Pashto, Pushto',
            'pt' => 'Portuguese',
            'qu' => 'Quechua',
            'rm' => 'Romansh',
            'rn' => 'Kirundi',
            'ro' => 'Romanian, Moldavian, Moldovan',
            'ru' => 'Russian',
            'rw' => 'Kinyarwanda',
            'sa' => 'Sanskrit (Sa?sk?ta)',
            'sc' => 'Sardinian',
            'sd' => 'Sindhi',
            'se' => 'Northern Sami',
            'sg' => 'Sango',
            'si' => 'Sinhala, Sinhalese',
            'sk' => 'Slovak',
            'sl' => 'Slovene',
            'sm' => 'Samoan',
            'sn' => 'Shona',
            'so' => 'Somali',
            'sq' => 'Albanian',
            'sr' => 'Serbian',
            'ss' => 'Swati',
            'st' => 'Southern Sotho',
            'su' => 'Sundanese',
            'sv' => 'Swedish',
            'sw' => 'Swahili',
            'ta' => 'Tamil',
            'te' => 'Telugu',
            'tg' => 'Tajik',
            'th' => 'Thai',
            'ti' => 'Tigrinya',
            'tk' => 'Turkmen',
            'tl' => 'Tagalog',
            'tn' => 'Tswana',
            'to' => 'Tonga (Tonga Islands)',
            'tr' => 'Turkish',
            'ts' => 'Tsonga',
            'tt' => 'Tatar',
            'tw' => 'Twi',
            'ty' => 'Tahitian',
            'ug' => 'Uighur, Uyghur',
            'uk' => 'Ukrainian',
            'ur' => 'Urdu',
            'uz' => 'Uzbek',
            've' => 'Venda',
            'vi' => 'Vietnamese',
            'vo' => 'VolapÃ¼k',
            'wa' => 'Walloon',
            'wo' => 'Wolof',
            'xh' => 'Xhosa',
            'yi' => 'Yiddish',
            'yo' => 'Yoruba',
            'za ' => 'Zhuang, Chuang',
            'zh' => 'Chinese',
            'zu' => 'Zulu',
        );
    }
}
