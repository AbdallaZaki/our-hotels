<?php

namespace App\HotelsProviders;

use App\HotelsProviders\Contracts\HotelsProviderInterface;
use App\MimicProvidersApis\Abstracts\TopHotelApiInterface;
use Illuminate\Support\Carbon;

class TopHotelProvider implements HotelsProviderInterface
{

    private $topHotelApi;

    private $providerName = "TopHotels";

    public function __construct(TopHotelApiInterface $topHotelApi)
    {
        $this->topHotelApi = $topHotelApi;
    }

    public function findHotels(string $from_date, string $to_date, string $city, int $adults_number): array
    {
        $topHotelsData = $this->topHotelApi->topHotelApi($this->convertToIsoInstant($from_date), $this->convertToIsoInstant($to_date), $city, $adults_number);

        return $this->prepareResponse($topHotelsData);
    }

    private function prepareResponse(array $hotels): array
    {
        $responseArray = [];

        foreach ($hotels as $hotel) {

            $responseArray[] = [

                "provider" => $this->providerName,

                "hotelName" => $hotel["hotelName"],

                "fare" => $this->calculateDiscount($hotel["price"], $hotel["discount"]),

                "amenities" => $hotel["amenities"],

                "rate" => $this->calculateRate($hotel["rate"]),
            ];
        }

        return $responseArray;
    }

    private function calculateDiscount(float $nightPrice, float $dicount): float
    {
        return $nightPrice - $dicount;
    }

    private function calculateRate(string $rate): int
    {
        return strlen($rate);
    }

    private function convertToIsoInstant(string $date): string
    {
        $parsedDate = Carbon::parse($date);

        return $parsedDate->toIso8601ZuluString();
    }

}
