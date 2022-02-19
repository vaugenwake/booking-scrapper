<?php

namespace Vaugenwake\BookingScraper\Models;

class FacilityModel
{

    public function __construct(
        public string $name,
        public array $items
    ) {
    }

    public function addItem(string $item): void
    {
        array_push($this->items, $item);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'items' => $this->items
        ];
    }
}
