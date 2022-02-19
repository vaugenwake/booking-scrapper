<?php

use Vaugenwake\BookingScraper\Exceptions\IntegrationNotImplementedException;
use Vaugenwake\BookingScraper\Integrations\IntegrationFactory;
use Vaugenwake\BookingScraper\Scrapper;
use function Termwind\{render, ask};

require __DIR__ . '/vendor/autoload.php';

// https://www.booking.com/hotel/gb/staybridge-suites-liverpool.en-gb.html?aid=304142;label=gen173nr-1DCAEoggI46AdIM1gEaFCIAQGYAQm4ARfIAQ_YAQPoAQGIAgGoAgO4AuK6w5AGwAIB0gIkMzk5MjZhMjAtZDNiMS00YjUyLWI5MWEtZmZlZTg2YTlmMTli2AIE4AIB;sid=80fe2d5770e23bea0b5a6b27d8f7b635;all_sr_blocks=3716608_328284902_2_1_0;checkin=2022-04-02;checkout=2022-04-03;dest_id=15936;dest_type=landmark;dist=0;group_adults=1;group_children=0;hapos=2;highlighted_blocks=3716608_328284902_2_1_0;hpos=2;matching_block_id=3716608_328284902_2_1_0;no_rooms=1;req_adults=1;req_children=0;room1=A;sb_price_type=total;sr_order=popularity;sr_pri_blocks=3716608_328284902_2_1_0__29480;srepoch=1645272466;srpvid=8877554839110273;type=total;ucfs=1&#hotelTmpl
$property = ask(<<<HTML
<span class="mt-1 mr-1 bg-green px-1 text-black">
    Property URL: 
</span>
HTML);

$integration = ask(<<<HTML
    <div class="mt-1">
    <span class="mr-1 bg-green px-1 text-black">
        Which integration would you like to use? (1 by default)
    </span>
    <ul class="list-none">
        <li>1. Booking.com</li>
        <li>2. Airbnb</li>
    </ul>
    <span class="mt-1 px-1">: </span>
    </div>
HTML);

try {
    $integration = IntegrationFactory::make($integration);
} catch (IntegrationNotImplementedException $e) {
    render(<<<HTML
        <span class="mt-1 mr-1 bg-red px-1 text-white"><strong>Error:</strong> Missing integration:</span>
        <p>{$e->getMessage()}</p>
    HTML);
    exit(1);
}

// Setup a browser
$scrapper = new Scrapper();
$scrapper->connect($property);

// Get the data from the scraped page for integration
$features = $scrapper->scrape($integration);

render($scrapper->renderConsole($features));

exit(0);
