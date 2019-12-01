<?php 

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DependenciesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
        $this->app->bind('App\MimicProvidersApis\Abstracts\BestHotelApiInterface',
        'App\MimicProvidersApis\BestHotelApi');

        $this->app->bind('App\MimicProvidersApis\Abstracts\TopHotelApiInterface',
        'App\MimicProvidersApis\TopHotelApi');
        
        $this->app->bind('App\Services\Abstracts\HotelSearchServiceInterface',
        'App\Services\HotelSearchService');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
