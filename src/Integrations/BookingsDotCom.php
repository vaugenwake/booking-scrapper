<?php

namespace Vaugenwake\BookingScraper\Integrations;

use Symfony\Component\DomCrawler\Crawler;
use Vaugenwake\BookingScraper\Contracts\IntegrationContract;
use Vaugenwake\BookingScraper\Models\AddressModel;
use Vaugenwake\BookingScraper\Models\FacilityModel;
use Vaugenwake\BookingScraper\Models\FeaturesModel;

class BookingsDotCom implements IntegrationContract
{
    public function extractFeatures(Crawler $crawler): FeaturesModel
    {

        // name
        $propertyName = $crawler->filter('#hp_hotel_name')->first()->text();

        // address
        $propertyAddress = $crawler->filter('.hp_address_subtitle')->first()->text();
        // This is not the best way to do this. Would be better to try and
        // parse this into x & y points and then use a standard API for a complete address object
        // https://geocoder-php.org/
        $propertyAddress = explode(',', $propertyAddress);

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
            address: new AddressModel(
                line1: $propertyAddress[0],
                line2: $propertyAddress[1],
                line3: null,
                country: $propertyAddress[3],
                postcode: $propertyAddress[2]
            ),
            facilities: $facilities,
            description: $propertyDescription
        );
    }
}
