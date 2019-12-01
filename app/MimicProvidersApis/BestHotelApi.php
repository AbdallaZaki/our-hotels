<?php

namespace App\MimicProvidersApis;

use App\MimicProvidersApis\Abstracts\BestHotelApiInterface;
use Illuminate\Support\Carbon;

class BestHotelApi implements BestHotelApiInterface
{

    /**
     * public function search exposed to search best hotels api
     * @param string $$fromDate
     * @param string $toDate
     * @param string $city
     * @param int $numberOfAdults
     * @return array $hotels
     */
    public function bestHotelApi(string $fromDate, string $toDate, string $city, int $numberOfAdults): array
    {

        $filteredHotels = [];

        $hotelsData = $this->bestHotelsData();

        foreach ($hotelsData as $hotel) {

            if ($this->dateFilter($hotel, $fromDate, $toDate) && $this->cityFilter($hotel, $city) &&
                $this->numberOfAdultsFilter($hotel, $numberOfAdults)) {

                $hotel['hotelFare'] = $this->calulateTotalCost($hotel['hotelFare'],
                    $fromDate,
                    $toDate,
                    $hotel['fromDate']
                    , $hotel['toDate']);

                unset($hotel['fromDate']);

                unset($hotel['toDate']);

                $filteredHotels[] = $hotel;
            }

        }

        return $filteredHotels;

    }

    /**
     * private function to filter hotels by date
     * @param array $hotel
     * @param string $from
     * @param string $to
     * @return bool true or false
     */
    private function dateFilter(array $hotel, string $fromDate, string $toDate): bool
    {
        $hotelFromDate = $this->isoLocalDate($hotel['fromDate']);

        $hotelToDate = $this->isoLocalDate($hotel['toDate']);

        $inputFromDate = $this->isoLocalDate($fromDate);

        $inputToDate = $this->isoLocalDate($toDate);

        return (

            ($inputFromDate >= $hotelFromDate && $inputFromDate <= $inputToDate) &&

            ($inputToDate >= $inputFromDate && $inputToDate <= $hotelToDate)

        ) ? true : false;
    }

    /**
     * private function to filter hotels by city
     * @param array $hotel
     * @param string $city
     * @return bool true or false
     */
    private function cityFilter(array $hotel, string $city): bool
    {
        return $hotel['city'] == $city;
    }

    /**
     * private function to filter hotels by adults count
     * @param array $hotel
     * @param int $numberOfAdults
     * @return bool true or false
     */
    private function numberOfAdultsFilter(array $hotel, int $numberOfAdults): bool
    {
        return $hotel['numberOfAdults'] == $numberOfAdults;
    }

    /**
     * private function to convert make sure its a valid iso local date
     * @param string $date
     * @return string iso local date
     */
    private function isoLocalDate(string $date): string
    {
        return date('Y-m-d', strtotime($date));
    }

    /**
     * private function to calculate reservation price
     * @param float $total
     * @param string $inputFromDate
     * @param string $inputToDate
     * @param string $fromDate
     * @param string $toDate
     * @return float price
     */
    private function calulateTotalCost(float $total, string $inputFromDate, string $inputToDate, string $fromDate, string $toDate): float
    {
        $availableDaysCount = $this->culculateDaysCount($fromDate, $toDate);

        $requestedDaysCount = $this->culculateDaysCount($inputFromDate, $inputToDate);

        return round((($requestedDaysCount / $availableDaysCount) * $total), 2);

    }

    /** private function to calculate days count
     * @param string $from
     * @param string $to
     * @return int reservation days count
     */
    private function culculateDaysCount(string $from, string $to): int
    {
        $fromDate = Carbon::createFromDate($from);
        $toDate = Carbon::createFromDate($to);
        return $fromDate->diffInDays($toDate);
    }

    /**
     * private function to mimic top hotels data source
     * @return array of hotels
     */
    private function bestHotelsData(): array
    {

        return [
            [
                "hotel" => "good hotel",
                "hotelRate" => 1,
                "hotelFare" => 9000,
                "city" => "BJS",
                "fromDate" => '2019-11-03',
                "toDate" => '2020-01-03',
                "numberOfAdults" => 3,
                "roomAmenities" => "Television,Computer and Internet access,Personal items,Hair dryer,Towels",
            ],
            [
                "hotel" => "good hotel 2",
                "hotelRate" => 3,
                "hotelFare" => 12000,
                "city" => "NYC",
                "fromDate" => '2019-11-03',
                "toDate" => '2020-01-03',
                "numberOfAdults" => 2,
                "roomAmenities" => "Television,Hair dryer,Towels",
            ],
            [
                "hotel" => "good hotel 3",
                "hotelRate" => 3,
                "hotelFare" => 10000,
                "city" => "BJS",
                "fromDate" => '2019-11-03',
                "toDate" => '2020-01-03',
                "numberOfAdults" => 1,
                "roomAmenities" => "Television,Computer and Internet access,Hair dryer,Towels",
            ],
            [
                "hotel" => "old hotel",
                "hotelRate" => 4,
                "hotelFare" => 13000,
                "city" => "BJS",
                "fromDate" => '2019-11-03',
                "toDate" => '2020-01-03',
                "numberOfAdults" => 1,
                "roomAmenities" => "Television,Computer and Internet access,Hair dryer,Towels",
            ],
            [
                "hotel" => "happy hotel 2",
                "hotelRate" => 3,
                "hotelFare" => 9500,
                "city" => "BJS",
                "fromDate" => '2019-11-03',
                "toDate" => '2020-01-03',
                "numberOfAdults" => 1,
                "roomAmenities" => "Television,Computer and Internet access,Personal items,Hair dryer,Towels",
            ],
            [
                "hotel" => "old hotel 2",
                "hotelRate" => 4,
                "hotelFare" => 14000,
                "city" => "NYC",
                "fromDate" => '2019-11-03',
                "toDate" => '2020-01-03',
                "numberOfAdults" => 3,
                "roomAmenities" => "Television,Computer and Internet access,Personal items,Hair dryer,Towels",
            ],

        ];

    }
}
