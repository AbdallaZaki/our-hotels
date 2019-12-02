# Our Hotels

This basic aggregator api for simple search hotels service

## Getting Started

Please clone this app with:

git clone https://github.com/AbdallaZaki/our-hotels.git

### Prerequisites

1- PHP 7.2+ installed on your machine

2- composer

### Installing

1- copy .env.example file to .env with this command

```
cp .env.example .env 
```
2- install packages using composer

```
composer install
```

3- run key generation command to create app secret key

```
php artisan key:generate
```
## Running the tests

Just run this command in the project root to run tests:

```
vendor/bin/phpunit
```
## Running the project

Just run this command in the project root to run project on default port 8000:

```
php artisan serve
```

### Testing search api

Just open your browser and enter something like:

```
http://localhost:8000/api/v1/search?adults_number=3&city=NYC&from_date=2019-12-03&to_date=2019-12-25 
```

### App skeleton

1- App directory

* App/MimicProvidersApis for mimicing best ans top hotels apis.

* App/HotelsProviders for adding best and top hotels provider or any new provider

* App/Services for OurHotels search service.

* App/providers for adding our DependenciesServiceProvider to bind our abstract to concrets

using service container.

* App/Http/OurHotelsController.

2- config diractory

* register our DependenciesServiceProvider in app.php providers list.

* adding our two hotels providers in hotels.php for dynamic loading in ourHotels service.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
