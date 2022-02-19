<?php

namespace Vaugenwake\BookingScraper\Contracts;

use Symfony\Component\DomCrawler\Crawler;
use Vaugenwake\BookingScraper\Models\FeaturesModel;

interface IntegrationContract
{
    public function extractFeatures(Crawler $crawler): FeaturesModel;
}
