<?php 

namespace App\MimicProvidersApis;

use Illuminate\Support\Carbon;

class TopHotelApi {
    
    // exposed best Hotels api
    public function topHotelApi(string $from,string $to, string $city ,int $adultsCount):array
    {   
        
        $filteredHotels = [];

        $hotelsData = $this->topHotelsData();

        foreach ($hotelsData as $hotel) {

            if($this->dateFilter($hotel,$from,$to)&&$this->cityFilter($hotel,$city)&&
            $this->adultsCountFilter($hotel,$adultsCount)) $filteredHotels[] = $hotel;

        }

        return $filteredHotels;

    }

    //filter hotels by date
    private function dateFilter(array $hotel, string $from,string $to):bool
    {   
       $hotelFrom = $this->isoInstant($hotel['from']);
       
       $hotelTo = $this->isoInstant($hotel['to']);

       $inputFrom = $this->isoInstant($from);
       
       $inputTo = $this->isoInstant($to);

       return (
            
            ($inputFrom>=$hotelFrom&&$inputFrom<=$inputTo) &&

            ($inputTo>=$inputFrom&&$inputTo<=$hotelTo) 

            )?true:false;
    }

    //filter hotels by city
    private function cityFilter(array $hotel, string $city):bool
    {
        return $hotel['city'] == $city;
    }

    //filter hotels by number of adults
    private function adultsCountFilter(array $hotel,int $adultsCount):bool
    {
        return $hotel['adultsCount'] == $adultsCount;
    }
    
    // convert string date to ISO_INSTANT
    private function isoInstant(string $date):string
    {
        $parsedDate = Carbon::parse($date);
         
        return $parsedDate->toIso8601ZuluString();
    }

    // mimicing top hotel api
    private function topHotelsData():array
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
                "amenities" => ["Television","Computer and Internet access","Personal items","Hair dryer","Towels"]
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
                "amenities" => ["Television","Computer and Internet access","Hair dryer","Towels"]
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
                "amenities" => ["Television","Computer and Internet access","Personal items","Hair dryer"]
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
                "amenities" => ["Television","Computer and Internet access","Hair dryer","Towels"]
            ],
            [
                "hotelName" => "happy hotel 2",
                "rate" => '***',
                "price" => 180,
                "discount" => 0,
                "city" => "NYC",
                "from" => '2019-10-01T10:15:30Z',
                "to" => '2019-12-20T10:15:30Z',
 	            "adultsCount" => 1,
                "amenities" => ["Television","Computer and Internet access","Personal items","Hair dryer","Towels"]
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
                "amenities" => ["Television","Personal items","Hair dryer","Towels"]
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
                "amenities" => ["Television","Computer and Internet access","Personal items","Hair dryer","Towels"]
            ]

        ];

    }

}