<?php

namespace App\MimicProvidersApis;

use App\MimicProvidersApis\Abstracts\TopHotelApiInterface;
use Illuminate\Support\Carbon;

class TopHotelApi implements TopHotelApiInterface
{

    /**
     * public function search exposed to search top hotels api
     * @param string $from
     * @param string $to
     * @param string $city
     * @param int $adultsCount
     * @return array $hotels
     */
    public function topHotelApi(string $from, string $to, string $city, int $adultsCount): array
    {

        $filteredHotels = [];

        $hotelsData = $this->topHotelsData();

        foreach ($hotelsData as $hotel) {

            if ($this->dateFilter($hotel, $from, $to) && $this->cityFilter($hotel, $city) &&
                $this->adultsCountFilter($hotel, $adultsCount)) {

                unset($hotel['from']);

                unset($hotel['to']);

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
    private function dateFilter(array $hotel, string $from, string $to): bool
    {
        $hotelFrom = $this->isoInstant($hotel['from']);

        $hotelTo = $this->isoInstant($hotel['to']);

        $inputFrom = $this->isoInstant($from);

        $inputTo = $this->isoInstant($to);

        return (

            ($inputFrom >= $hotelFrom && $inputFrom <= $inputTo) &&

            ($inputTo >= $inputFrom && $inputTo <= $hotelTo)

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
     * @param int $adultsCount
     * @return bool true or false
     */
    private function adultsCountFilter(array $hotel, int $adultsCount): bool
    {
        return $hotel['adultsCount'] == $adultsCount;
    }

    /**
     * private function to convert date to iso instant formats
     * @param string $date
     * @return string iso instant format
     */
    private function isoInstant(string $date): string
    {
        $parsedDate = Carbon::parse($date);

        return $parsedDate->toIso8601ZuluString();
    }

    /**
     * private function to mimic top hotels data source
     * @return array of hotels
     */
    private function topHotelsData(): array
    {

        return [
            [
                "hotelName" => "good hotel",
                "rate" => '*',
                "price" => 150,
                "discount" => 15,
                "city" => "BJS",
                "from" => '2019-11-03T10:15:30Z',
                "to" => '2019-12-05T10:15:30Z',
                "adultsCount" => 3,
                "amenities" => ["Television", "Computer and Internet access", "Personal items", "Hair dryer", "Towels"],
            ],
            [
                "hotelName" => "happy hotel",
                "rate" => '*****',
                "price" => 100,
                "discount" => 0,
                "city" => "BJS",
                "from" => '2019-11-01T10:15:30Z',
                "to" => '2019-12-10T10:15:30Z',
                "adultsCount" => 2,
                "amenities" => ["Television", "Computer and Internet access", "Hair dryer", "Towels"],
            ],
            [
                "hotelName" => "new hotel",
                "rate" => '****',
                "price" => 120,
                "discount" => 5,
                "city" => "AUX",
                "from" => '2019-11-01T10:15:30Z',
                "to" => '2019-11-10T10:15:30Z',
                "adultsCount" => 3,
                "amenities" => ["Television", "Computer and Internet access", "Personal items", "Hair dryer"],
            ],
            [
                "hotelName" => "old hotel",
                "rate" => '*****',
                "price" => 100,
                "discount" => 0,
                "city" => "OTP",
                "from" => '2019-11-02T10:15:30Z',
                "to" => '2019-12-15T10:15:30Z',
                "adultsCount" => 2,
                "amenities" => ["Television", "Computer and Internet access", "Hair dryer", "Towels"],
            ],
            [
                "hotelName" => "happy hotel 2",
                "rate" => '***',
                "price" => 180,
                "discount" => 5,
                "city" => "NYC",
                "from" => '2019-10-01T10:15:30Z',
                "to" => '2019-12-25T10:15:30Z',
                "adultsCount" => 3,
                "amenities" => ["Television", "Computer and Internet access", "Personal items", "Hair dryer", "Towels"],
            ],
            [
                "hotelName" => "old hotel 2",
                "rate" => '**',
                "price" => 70,
                "discount" => 5,
                "city" => "NYC",
                "from" => '2019-09-01T10:15:30Z',
                "to" => '2019-12-30T10:15:30Z',
                "adultsCount" => 2,
                "amenities" => ["Television", "Personal items", "Hair dryer", "Towels"],
            ],
            [
                "hotelName" => "new hotel 3",
                "rate" => '*****',
                "price" => 160,
                "city" => "NYC",
                "from" => '2019-11-01T10:15:30Z',
                "to" => '2019-11-30T10:15:30Z',
                "adultsCount" => 3,
                "discount" => 10,
                "amenities" => ["Television", "Computer and Internet access", "Personal items", "Hair dryer", "Towels"],
            ],

        ];

    }

}
