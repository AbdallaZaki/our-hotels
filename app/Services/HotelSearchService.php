<?php

namespace App\Services;

use App\Services\Abstracts\HotelSearchServiceInterface;

class HotelSearchService implements HotelSearchServiceInterface
{

    private $hotelsProviders = [];

    public function __construct()
    {
        $this->loadProviders();
    }

    public function search(string $from_date, string $to_date, string $city, int $adults_number): array
    {
        $hotelsProvidersResponses = [];

        foreach ($this->hotelsProviders as $hotelProvider) {

            $hotelsProvidersResponses[] = $hotelProvider->findHotels($from_date, $to_date, $city, $adults_number);

        }

        $combinedProvidersResponses = $this->unifiyProvidersResponses($hotelsProvidersResponses);

        $sortedProvidersResponses = $this->sortByRate($combinedProvidersResponses);

        return $this->removeRate($sortedProvidersResponses);

    }

    private function removeRate(array $hotels): array
    {
        $filteredHotels = [];

        foreach ($hotels as $hotel) {

            unset($hotel['rate']);

            $filteredHotels[] = $hotel;
        }

        return $filteredHotels;
    }

    private function sortByRate(array $hotels): array
    {
        uasort($hotels, function ($hotelA, $hotelB) {
            if ($hotelA['rate'] == $hotelB['rate']) {
                return 0;
            }

            return ($hotelA['rate'] > $hotelB['rate']) ? -1 : 1;
        });

        return $hotels;
    }

    private function unifiyProvidersResponses(array $responses): array
    {
        $responsesCount = count($responses);

        if (!$responsesCount) {
            return [];
        }

        if ($responsesCount == 1) {
            return $responsesCount[0];
        }

        return array_merge(...$responses);
    }

    private function loadProviders()
    {

        $hotelsProviders = config('hotels.providers');

        if (count($hotelsProviders)) {

            foreach ($hotelsProviders as $hotelProvider) {

                $this->hotelsProviders[] = app()->make($hotelProvider);
            }
        }
    }

}
