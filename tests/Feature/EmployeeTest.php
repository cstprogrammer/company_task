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

    /**
     * test get all employee by department
     *
     * @return void
     */
    public function test_get_all_employee_by_department()
    {
        $response = $this->json('GET', 'api/employeeListByDepartment/2');
        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test get employee details
     *
     * @return void
     */
    public function test_get_employee_details()
    {
        $response = $this->json('GET', 'api/employeeDetails/2');
        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }
}
