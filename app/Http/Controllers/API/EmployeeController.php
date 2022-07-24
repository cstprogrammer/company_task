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
        })->orderBy('id', 'desc')->paginate(1);
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
}
