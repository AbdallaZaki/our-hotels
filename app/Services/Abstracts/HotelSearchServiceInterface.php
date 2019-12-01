<?php

namespace App\Services\Abstracts;

interface HotelSearchServiceInterface
{

    public function search(string $from_date, string $to_date, string $city, int $adults_number): array;
}
