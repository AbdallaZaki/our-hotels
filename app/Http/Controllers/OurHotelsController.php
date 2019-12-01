<?php

namespace App\Http\Controllers;

use App\Services\Abstracts\HotelSearchServiceInterface;

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

    public function searchHotels()
    {
        return $this->searchHotelsService->search('2019-12-03', '2019-12-25', 'NYC', 3);
    }
}
