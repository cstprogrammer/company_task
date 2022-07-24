<?php

namespace Tests\Feature;

use Tests\TestCase;

class CompanyTest extends TestCase
{
    /**
     * test get all companies.
     *
     * @return void
     */
    public function test_get_all_company()
    {
        $response = $this->json('GET', 'api/companies');
        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }
}
