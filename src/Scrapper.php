<?php

namespace Vaugenwake\BookingScraper;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;

class Scrapper {

    public function __construct(
        private HttpBrowser $browser = new HttpBrowser()
    )
    {}

    public function crawl(string $url): Crawler {
        return $this->browser->request('GET', $url);
    }

}