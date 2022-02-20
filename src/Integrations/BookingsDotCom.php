<?php

namespace Vaugenwake\BookingScraper\Integrations;

use Symfony\Component\DomCrawler\Crawler;
use Vaugenwake\BookingScraper\Contracts\IntegrationContract;
use Vaugenwake\BookingScraper\Models\AddressModel;
use Vaugenwake\BookingScraper\Models\FacilityModel;
use Vaugenwake\BookingScraper\Models\FeaturesModel;

class BookingsDotCom extends BaseIntegration implements IntegrationContract
{
    public function extractFeatures(Crawler $crawler): FeaturesModel
    {

        // name
        $propertyName = $crawler->filter('#hp_hotel_name')->first()->text();

        // address
        $propertyAddress = $crawler->filter('.hp_address_subtitle')->first()->text();

        // Gecode and parse address
        $propertyAddress = $this->parseAddress($propertyAddress);

        // facilities
        $facilities = [];
        $propertyFacilities = $crawler->filter('.hotel-facilities-group');
        $propertyFacilities->each(function (Crawler $item) use (&$facilities) {
            $headline = $item->filter('.hotel-facilities-group__title')->first()->text();
            $features = $item->filter('.hotel-facilities-group__list-item');

            $feature = new FacilityModel($headline, []);
            $features->each(function (Crawler $featureItem) use (&$feature) {
                $feature->addItem($featureItem->text());
            });

            $facilities[] = $feature;
        });

        // description
        $propertyDescription = $crawler->filter('.hp_desc_main_content #property_description_content')->text();

        return new FeaturesModel(
            name: $propertyName,
            address: new AddressModel($propertyAddress),
            facilities: $facilities,
            description: $propertyDescription
        );
    }
}
