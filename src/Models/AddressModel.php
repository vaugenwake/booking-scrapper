<?php

namespace Vaugenwake\BookingScraper\Models;

use Geocoder\Location;

class AddressModel
{

    public function __construct(
        public Location $address
    ) {
    }

    public function toArray(): array
    {
        return $this->address->toArray();
    }

    public function toString(): string
    {
        return $this->address->getStreetNumber() . " " . $this->address->getStreetName() . ", " . $this->address->getLocality() . ", " . $this->address->getCountry() . ", " . $this->address->getPostalCode();
    }
}
