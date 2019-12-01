<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Abstracts\HotelSearchServiceInterface;

class OurHotelsController extends Controller
{   
    
    private $searchHotelsService;

    public function __construct(HotelSearchServiceInterface $searchHotelsService)
    {
        $this->searchHotelsService = $searchHotelsService;
    }

    public function searchHotels()
    {   
        // "from" => '2019-11-01T10:15:30Z',
        // "to" => '2019-12-10T10:15:30Z',

        //return (new BestHotelProvider(new BestHotelApi()))->findHotels('2019-12-03','2019-12-25','NYC',3);
       
        //return (new TopHotelProvider(new TopHotelApi()))->findHotels('2019-12-03','2019-12-25','NYC',3);
       // return (new BestHotelApi())->bestHotelApi('2019-12-03','2019-12-25','NYC','3');
        
        //return (new TopHotelApi())->topHotelApi('2019-11-30T10:15:30Z','2019-12-1T10:15:30Z','BJS',3);
        
        return  $this->searchHotelsService->search('2019-12-03','2019-12-25','NYC',3);
    }
}
