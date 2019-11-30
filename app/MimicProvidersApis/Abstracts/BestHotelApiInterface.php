<?php 

namespace App\MimicProvidersApis\Abstracts;

interface BestHotelApiInterface {

    public function bestHotelApi(string $fromDate,string $toDate, string $city ,int $numberOfAdults):array;  
}