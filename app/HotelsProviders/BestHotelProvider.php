<?php

namespace App\HotelsProviders;

use App\HotelsProviders\Contracts\HotelsProviderInterface;
use App\MimicProvidersApis\Abstracts\BestHotelApiInterface;
use Illuminate\Support\Carbon;

class BestHotelProvider implements HotelsProviderInterface
{
    /**
     * private field for holding best hoteles api.
     */
    private $bestHotelApi;

    /**
     * private field for storing current provider name.
     */
    private $providerName = "BestHotels";

    /**
     * public function constructor.
     * @param BestHotelApiInterface $bestHotelApi for injecting best Hotel Api.
     */
    public function __construct(BestHotelApiInterface $bestHotelApi)
    {
        $this->bestHotelApi = $bestHotelApi;
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
        $bestHotelsData = $this->bestHotelApi->bestHotelApi($from_date, $to_date, $city, $adults_number);

        return $this->prepareResponse($bestHotelsData, $from_date, $to_date);
    }

    /**
     * private function to prepare search response.
     * @param array $hotels
     * @param string $from_date
     * @param string $to_date
     * @return array $hotels
     */
    private function prepareResponse(array $hotels, $from_date, $to_date): array
    {
        $responseArray = [];

        foreach ($hotels as $hotel) {
            $responseArray[] = [

                "provider" => $this->providerName,

                "hotelName" => $hotel["hotel"],

                "fare" =>

                $this->culculateNightFare(
                    $this->culculateDaysCount($from_date, $to_date),
                    $hotel["hotelFare"]
                ),

                "amenities" => explode(',', $hotel["roomAmenities"]),

                "rate" => $hotel["hotelRate"],
            ];
        }

        return $responseArray;
    }

    /**
     * private function to culculate night fare.
     * @param int $dayCount
     * @param float $hotelFare
     * @return float per night fare
     */
    private function culculateNightFare(int $dayCount, float $hotelFare): float
    {
        return round(($hotelFare / $dayCount), 2);
    }

    /**
     * private function to culculate days of reservation.
     * @param string $from_date
     * @param string $to_date
     * @return int days count
     */
    private function culculateDaysCount(string $from_date, string $to_date): int
    {
        $fromDate = Carbon::createFromDate($from_date);
        $toDate = Carbon::createFromDate($to_date);
        return $fromDate->diffInDays($toDate);
    }
}
