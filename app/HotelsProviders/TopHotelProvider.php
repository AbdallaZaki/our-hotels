<?php

namespace App\HotelsProviders;

use App\HotelsProviders\Contracts\HotelsProviderInterface;
use App\MimicProvidersApis\Abstracts\TopHotelApiInterface;
use Illuminate\Support\Carbon;

class TopHotelProvider implements HotelsProviderInterface
{
    /**
     * private field for holding top hoteles api.
     */
    private $topHotelApi;

    /**
     * private field for storing current provider name.
     */
    private $providerName = "TopHotels";

    /**
     * public function constructor.
     * @param TopHotelApiInterface $topHotelApi for injecting top Hotel Api.
     */
    public function __construct(TopHotelApiInterface $topHotelApi)
    {
        $this->topHotelApi = $topHotelApi;
    }

    /**
     * public function search exposed to be used for serach in hotels providers data
     * @param string $from_date
     * @param string $to_date
     * @param string $city
     * @param int $adults_number
     * @return array $hotels
     */
    public function findHotels(string $from_date, string $to_date, string $city, int $adults_number): array
    {
        $topHotelsData = $this->topHotelApi->topHotelApi($this->convertToIsoInstant($from_date), $this->convertToIsoInstant($to_date), $city, $adults_number);

        return $this->prepareResponse($topHotelsData);
    }

    /**
     * private function to prepare search response.
     * @param array $hotels
     * @param string $from_date
     * @param string $to_date
     * @return array $hotels
     */
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

    /**
     * private function to  calculate discount.
     * @param float $nightPrice
     * @param float $dicount
     * @return float night fare after discount
     */
    private function calculateDiscount(float $nightPrice, float $dicount): float
    {
        return $nightPrice - $dicount;
    }

    /**
     * private function to prepare search response.
     * @param array $hotels
     * @param string $from_date
     * @param string $to_date
     * @return array $hotels
     */
    private function calculateRate(string $rate): int
    {
        return strlen($rate);
    }

    /**
     * private function convert date to iso instant format.
     * @param string $date
     * @return string iso instant date.
     */
    private function convertToIsoInstant(string $date): string
    {
        $parsedDate = Carbon::parse($date);

        return $parsedDate->toIso8601ZuluString();
    }
}
