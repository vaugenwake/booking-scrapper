<?php

namespace Vaugenwake\BookingScraper;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Vaugenwake\BookingScraper\Contracts\IntegrationContract;
use Vaugenwake\BookingScraper\Models\FeaturesModel;

class Scrapper
{

    private Crawler $crawler;

    public function __construct(
        private HttpBrowser $browser = new HttpBrowser()
    ) {
    }

    public function connect(string $url): void
    {
        $this->crawler = $this->browser->request('GET', $url);
    }

    public function scrape(IntegrationContract $scrapper): FeaturesModel
    {
        return $scrapper->extractFeatures($this->crawler);
    }

    public function renderConsole(FeaturesModel $featuresModel): string
    {
        $loader = new FilesystemLoader(__DIR__ . '/views');
        $twig = new Environment($loader, []);

        return $twig->render('console.html.twig', ['features' => $featuresModel]);
    }
}
