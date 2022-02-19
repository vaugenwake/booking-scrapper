<?php

use Vaugenwake\BookingScraper\Scrapper;

require __DIR__ . '/vendor/autoload.php';

(new \NunoMaduro\Collision\Provider())->register();

// https://www.booking.com/hotel/gb/staybridge-suites-liverpool.en-gb.html?aid=304142;label=gen173nr-1DCAEoggI46AdIM1gEaFCIAQGYAQm4ARfIAQ_YAQPoAQGIAgGoAgO4AuK6w5AGwAIB0gIkMzk5MjZhMjAtZDNiMS00YjUyLWI5MWEtZmZlZTg2YTlmMTli2AIE4AIB;sid=80fe2d5770e23bea0b5a6b27d8f7b635;all_sr_blocks=3716608_328284902_2_1_0;checkin=2022-04-02;checkout=2022-04-03;dest_id=15936;dest_type=landmark;dist=0;group_adults=1;group_children=0;hapos=2;highlighted_blocks=3716608_328284902_2_1_0;hpos=2;matching_block_id=3716608_328284902_2_1_0;no_rooms=1;req_adults=1;req_children=0;room1=A;sb_price_type=total;sr_order=popularity;sr_pri_blocks=3716608_328284902_2_1_0__29480;srepoch=1645272466;srpvid=8877554839110273;type=total;ucfs=1&#hotelTmpl
//$property = readline('Please enter the booking.com property page URL: ');
$property = 'https://www.booking.com/hotel/gb/staybridge-suites-liverpool.en-gb.html?aid=304142;label=gen173nr-1DCAEoggI46AdIM1gEaFCIAQGYAQm4ARfIAQ_YAQPoAQGIAgGoAgO4AuK6w5AGwAIB0gIkMzk5MjZhMjAtZDNiMS00YjUyLWI5MWEtZmZlZTg2YTlmMTli2AIE4AIB;sid=80fe2d5770e23bea0b5a6b27d8f7b635;all_sr_blocks=3716608_328284902_2_1_0;checkin=2022-04-02;checkout=2022-04-03;dest_id=15936;dest_type=landmark;dist=0;group_adults=1;group_children=0;hapos=2;highlighted_blocks=3716608_328284902_2_1_0;hpos=2;matching_block_id=3716608_328284902_2_1_0;no_rooms=1;req_adults=1;req_children=0;room1=A;sb_price_type=total;sr_order=popularity;sr_pri_blocks=3716608_328284902_2_1_0__29480;srepoch=1645272466;srpvid=8877554839110273;type=total;ucfs=1&#hotelTmpl';

// Setup a browser
$scrapper = new Scrapper();
$propertyPage = $scrapper->crawl($property);

// Items
$propertyName = $propertyPage->filter('#hp_hotel_name')->first()->text();
$propertyAddress = $propertyPage->filter('.hp_address_subtitle')->first()->text();

$output = [
    'name' => $propertyName,
    'address' => $propertyAddress
];

\Termwind\render(<<<HTML
    <div>
        <div class="px-1 bg-green-600 text-black">Results:</div>
        <table>
            <thead>
                <th>Item</th>
                <th>Value</th>
            </thead>
            <tbody>
                <tr>
                    <td>Name</td>
                    <td>{$output['name']}</td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>{$output['address']}</td>
                </tr>
            </tbody>    
        </table>
    </div>
HTML);

exit(1);