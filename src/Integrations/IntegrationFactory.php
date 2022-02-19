<?php

namespace Vaugenwake\BookingScraper\Integrations;

use Exception;
use Vaugenwake\BookingScraper\Contracts\IntegrationContract;
use Vaugenwake\BookingScraper\Exceptions\IntegrationNotImplementedException;

class IntegrationFactory
{

    public static function make(?string $provider): IntegrationContract
    {
        switch ($provider) {
            case "1":
                return new BookingsDotCom;
            case "2":
                throw new IntegrationNotImplementedException("Airbnb has not been implemented yet");
            default:
                return new BookingsDotCom;
        }
    }
}
