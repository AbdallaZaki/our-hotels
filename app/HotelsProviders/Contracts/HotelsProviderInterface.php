<?php 

namespace App\HotelsProviders\Contracts;

interface HotelsProviderInterface {
    
    public function findHotels(string $from_date,string $to_date,string $city,int $adults_number):array;

}