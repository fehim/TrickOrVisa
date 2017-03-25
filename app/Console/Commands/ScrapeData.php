<?php

namespace App\Console\Commands;

use App\Services\WikipediaScraperService;
use Illuminate\Console\Command;

class ScrapeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:wikipedia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape data from wikipedia';

    /**
     * Execute the console command.
     *
     * @param WikipediaScraperService $scraper
     * @return mixed
     */
    public function handle(WikipediaScraperService $scraper)
    {
        $scraper->scrapeCountryData();
        $scraper->scrapeVisaData();
        $this->info('All done!');
    }
}
