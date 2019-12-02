<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OurHotelsSearchTest extends TestCase
{
    /**
     * A basic test for our hotels search api.
     *
     * @return void
     */
    public function testOurHotelsWithValidInputsTest()
    {
        $response = $this->call('GET', '/api/v1/search', [
            "adults_number"=>3,
            "city"=>"NYC",
            "from_date"=>"2019-12-03",
            "to_date"=>"2019-12-25"
        ]);

        $response->assertStatus(200);
    }

    /**
     * A basic test for our hotels search api with validation errors
     *
     * @return void
     */
    public function testOurHotelsWithInValidInputsTest()
    {
        $response = $this->call('GET', '/api/v1/search', [
            "adults_number"=>7,
            "city"=>"NYC]",
            "from_date"=>"2019-12-03",
            "to_date"=>"2019-12-25"
        ]);

        $response->assertStatus(422);
    }
}
