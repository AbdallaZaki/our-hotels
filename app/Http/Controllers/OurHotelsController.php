<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MimicProvidersApis\BestHotelApi;

use App\MimicProvidersApis\TopHotelApi;

class OurHotelsController extends Controller
{
    public function searchHotels()
    {   
        // "from" => '2019-11-01T10:15:30Z',
        // "to" => '2019-12-10T10:15:30Z',
       
        //return (new BestHotelApi())->bestHotelApi('2019-12-03','2019-12-25','NYC','3');
        
        return (new TopHotelApi())->topHotelApi('2019-11-30T10:15:30Z','2019-12-1T10:15:30Z','BJS',3);

    }
}
