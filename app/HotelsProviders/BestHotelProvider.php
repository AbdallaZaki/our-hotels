<?php

namespace App\HotelsProviders;

use App\HotelsProviders\Contracts\HotelsProviderInterface;
use App\MimicProvidersApis\Abstracts\BestHotelApiInterface;
use Illuminate\Support\Carbon;

class BestHotelProvider implements HotelsProviderInterface
{

    private $bestHotelApi;

    private $providerName = "BestHotels";

    public function __construct(BestHotelApiInterface $bestHotelApi)
    {

        $this->bestHotelApi = $bestHotelApi;
    }

    public function findHotels(string $from_date, string $to_date, string $city, int $adults_number): array
    {
        $bestHotelsData = $this->bestHotelApi->bestHotelApi($from_date, $to_date, $city, $adults_number);

        return $this->prepareResponse($bestHotelsData,$from_date,$to_date);
    }

    private function prepareResponse(array $hotels,$from_date,$to_date):array
    {
        $responseArray = [];

        foreach ($hotels as $hotel) {

            $responseArray[] = [

                "provider" => $this->providerName,

                "hotelName" => $hotel["hotel"],

                "fare" =>

                $this->culculateNightFare(
                    $this->culculateDaysCount($from_date,$to_date),
                    $hotel["hotelFare"]),

                "amenities" => explode(',', $hotel["roomAmenities"]),

                "rate" => $hotel["hotelRate"],
            ];
        }

        return $responseArray;
    }

    private function culculateNightFare(int $dayCount, float $hotelFare): float
    {
        return round(($hotelFare / $dayCount), 2);
    }

    // calculate days diff count
    private function culculateDaysCount(string $from_date, string $to_date): int
    {
        $fromDate = Carbon::createFromDate($from_date);
        $toDate = Carbon::createFromDate($to_date);
        return $fromDate->diffInDays($toDate);
    }

}
