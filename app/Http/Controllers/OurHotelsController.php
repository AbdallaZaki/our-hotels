<?php

namespace App\Http\Controllers;

use App\Http\Requests\OurHotels\SearchRequest;
use App\Services\Abstracts\HotelSearchServiceInterface;
use Illuminate\Http\Request;

class OurHotelsController extends Controller
{
    /**
     * private field for holding search.
     */
    private $searchHotelsService;

    /**
     * public function constructor.
     * @param HotelSearchServiceInterface for injecting  search hotels service.
     */
    public function __construct(HotelSearchServiceInterface $searchHotelsService)
    {
        $this->searchHotelsService = $searchHotelsService;
    }
    
    /**
     * public function to serve search hotel route.
     * @param SearchRequest for request.
     */
    public function searchHotels(SearchRequest $request)
    {
        $hotels = $this->searchHotelsService->search($request->from_date,
            $request->to_date,
            $request->city,
            $request->adults_number);
        
        return $this->readifyResponse($hotels);
    }
    
    /**
     * private function to readify response
     * @param array $hotels
     * @return Response json 
     */
    private function readifyResponse(array $hotels)
    {   
        $hotelsCount = count($hotels);

        $message = $hotelsCount?"We found your hotels!":"We can't find hotels!";

        return response()->json(['hotels'=>$hotels,'message' => $message],200);
    }
}
