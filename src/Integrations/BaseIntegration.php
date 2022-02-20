<?php

namespace Vaugenwake\BookingScraper\Integrations;

use Geocoder\Exception\Exception;
use Geocoder\Location;
use Geocoder\Provider\Mapbox\Mapbox;
use Geocoder\Query\GeocodeQuery;
use Geocoder\StatefulGeocoder;
use Http\Adapter\Guzzle6\Client;

class BaseIntegration
{

    public function parseAddress(string $address): ?Location
    {
        $httpClient = new Client();
        $provider = new Mapbox($httpClient, $_ENV['MAPBOX_KEY']);
         $geocoder = new StatefulGeocoder($provider, 'en');

         try {
             return $geocoder->geocodeQuery(GeocodeQuery::create($address))->first();
         } catch (Exception $e) {
             return null;
         }
    }
}
