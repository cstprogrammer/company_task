<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companies = Company::when($request->q, function ($query, $q) {
            $query->where('name', 'LIKE', '%'.$q.'%');
        })->orderBy('id', 'desc')->paginate(10);

        //check data in records
        if ($companies->total() == 0) {
            $response['success'] = false;
            $response['message'] = 'No data Found.';

            return $this->sendResponse($response);
        } else {
            $response['success'] = true;
            $response['status'] = 200;
            $response['message'] = 'Companies retrieved successfully.';

            return CompanyResource::collection($companies)->additional($response);
        }
    }
}
