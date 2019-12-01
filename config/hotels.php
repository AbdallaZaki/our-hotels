<?php

return [

   /*
    |--------------------------------------------------------------------------
    | Hotels Providers
    |--------------------------------------------------------------------------
    |
    | This option defines the registered hotel providers.
    |
    */ 

    'providers' => [
        
        'top_hotels' => App\HotelsProviders\TopHotelProvider::class,
        
        'best_hotels' => App\HotelsProviders\BestHotelProvider::class,
    ]
    
];