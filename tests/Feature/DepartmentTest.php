<?php

namespace Tests\Feature;

use Tests\TestCase;

class DepartmentTest extends TestCase
{
    /**
     * test get all departments.
     *
     * @return void
     */
    public function test_get_all_department()
    {
        $response = $this->json('GET', 'api/departments');
        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }
}
