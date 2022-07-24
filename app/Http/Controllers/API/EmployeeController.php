<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employees = Employee::when($request->q, function ($query, $q) {
            $query->where('name', 'LIKE', '%'.$q.'%');
            $query->Orwhere('employee_number', $q);
            $query->Orwhere('email', 'LIKE', '%'.$q.'%');
        })->orderBy('id', 'desc')->paginate(10);
        //check data in records
        if ($employees->total() == 0) {
            $response['success'] = false;
            $response['message'] = 'No data Found.';

            return $this->sendResponse($response);
        } else {
            $response['success'] = true;
            $response['status'] = 200;
            $response['message'] = 'Employees retrieved successfully.';

            return EmployeeResource::collection($employees)->additional($response);
        }
    }

    /**
     * Listing employees in a specific department of a company
     */
    public function employeeListByDepartment($department_id, Request $request)
    {
        $employees = Employee::when($request->q, function ($query, $q) {
            $query->where('name', 'LIKE', '%'.$q.'%');
            $query->Orwhere('employee_number', $q);
            $query->Orwhere('email', 'LIKE', '%'.$q.'%');
        })
            ->where('department_id', $department_id)
            ->orderBy('id', 'desc')
            ->paginate(1);
        //check data in records
        if ($employees->total() == 0) {
            $response['success'] = false;
            $response['message'] = 'No data Found.';

            return $this->sendResponse($response);
        } else {
            $response['success'] = true;
            $response['status'] = 200;
            $response['message'] = 'Employees retrieved successfully.';

            return EmployeeResource::collection($employees)->additional($response);
        }
    }

    /**
     * Viewing employee details with respective company and departments
     */
    public function employeeDetails($employee_id, Request $request)
    {
        $employee = Employee::where('id', $employee_id)
            ->with('company')->with('department')->first();
        //check data in records
        if ($employee) {
            $responsedata = json_decode($employee, true);

            return response()->json(['success' => true, 'status_code' => 200, 'message' => 'Employee details retrieved successfully.', 'data' => $responsedata]);
        } else {
            $response['success'] = false;
            $response['message'] = 'No data Found.';

            return $this->sendResponse($response);
        }
    }
}
