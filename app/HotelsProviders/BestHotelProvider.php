<?php 

namespace App\HotelsProviders;

use App\HotelsProviders\Contracts\HotelsProviderInterface;

use App\MimicProvidersApis\Abstracts\BestHotelApiInterface;

class BestHotelProvider implements HotelsProviderInterface
{   
    
    private $bestHotelApi;

    public function __construct(BestHotelApiInterface $bestHotelApi) {
        
        $this->bestHotelApi = $bestHotelApi;
    }

    public function findHotels(string $from_date,string $to_date,string $city,int $adults_number):array
    {
        $bestHotelsData = $this->bestHotelApi->bestHotelApi($from_date,$to_date,$city,$adults_number);

        return $bestHotelsData;
    }
}
