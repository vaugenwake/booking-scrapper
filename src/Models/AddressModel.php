<?php

namespace Vaugenwake\BookingScraper\Models;

class AddressModel
{

    public function __construct(
        public string $line1,
        public ?string $line2,
        public ?string $line3,
        public string $country,
        public string $postcode,
    ) {
    }

    public function toArray(): array
    {
        return [
            'address_line_1' => $this->line1,
            'address_line_2' => $this->line2,
            'address_line_3' => $this->line3,
            'address_country' => $this->country,
            'address_postcode' => $this->postcode,
        ];
    }

    public function toString(): string
    {
        return "$this->line1, $this->line2, $this->line3, $this->country, $this->postcode";
    }
}
