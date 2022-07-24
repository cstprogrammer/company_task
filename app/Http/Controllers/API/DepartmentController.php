<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $departments = Department::when($request->q, function ($query, $q) {
            $query->where('name', 'LIKE', '%'.$q.'%');
        })->orderBy('id', 'desc')->paginate(10);

        //check data in records
        if ($departments->total() == 0) {
            $response['success'] = false;
            $response['message'] = 'No data Found.';

            return $this->sendResponse($response);
        } else {
            $response['success'] = true;
            $response['status'] = 200;
            $response['message'] = 'Departments retrieved successfully.';

            return DepartmentResource::collection($departments)->additional($response);
        }
    }
}
