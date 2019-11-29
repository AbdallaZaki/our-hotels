<?php 

namespace App\HotelsProviders\Contracts;

interface HotelsProviderInterface {
    
    public function findHotels(Date $from_date,Date $to_date,string $city,int $adults_number):array;

}