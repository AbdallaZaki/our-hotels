<?php 

namespace App\MimicProvidersApis\Abstracts;


interface TopHotelApiInterface {

    public function topHotelApi(string $from,string $to, string $city ,int $adultsCount):array;
    
}