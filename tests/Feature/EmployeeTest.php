<?php

namespace Tests\Feature;

use Tests\TestCase;

class EmployeeTest extends TestCase
{
    /**
     * test get all employee.
     *
     * @return void
     */
    public function test_get_all_employee()
    {
        $response = $this->json('GET', 'api/employees');
        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }
}
