<?php

namespace Vaugenwake\BookingScraper\Models;

class FeaturesModel
{

    public function __construct(
        public string $name,
        public AddressModel $address,
        public array $facilities,
        public string $description
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'address' => $this->address->toArray(),
            'facilities' => $this->facilities,
            'description' => $this->description
        ];
    }
}
