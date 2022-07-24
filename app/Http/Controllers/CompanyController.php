<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Repositories\CommonRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CompanyController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Company $company)
    {
        parent::__construct();
        // set the model
        $this->model = new CommonRepository($company);
    }

    /*
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Company/Create');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //start transaction
        DB::beginTransaction();
        try {
            $company = $this->model->find($id);
            $this->model->delete($id);
            DB::commit();
            //end transaction
            return to_route('companies.index')->with('success', 'Company '.$company->name.' deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollback();

            return to_route('companies.index')->with('error', 'Error deleting company. '.$th->getMessage());
        }
    }

    /*
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $company = $this->model->find($id);

            return Inertia::render('Company/Edit', [
                'company' => $company,
            ]);
        } catch (\Throwable $th) {
            return to_route('companies.index')->with('error', 'Error creating user. '.$th->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companies = $this->model->getModel()->when($request->q, function ($query, $q) {
            $query->where('name', 'LIKE', '%'.$q.'%');
            $query->Orwhere('location', 'LIKE', '%'.$q.'%');
        })->orderBy('id', 'desc')->paginate(10);

        return Inertia::render('Company/Index', [
            'companies' => $companies,
        ]);
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //check form validation rule
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required',  'max:255'],
            'contact' => ['required',  'max:255'],
        ]);

        //start transaction
        DB::beginTransaction();
        try {
            $create = $this->model->create($request->all());

            DB::commit();
            //end transaction
            return to_route('companies.index')->with('success', 'Company '.$create->name.' created successfully.');
        } catch (\Throwable $th) {
            DB::rollback();

            return to_route('companies.index')->with('error', 'Error creating company. '.$th->getMessage());
        }
    }

    /*
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //check form validation rule
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required',  'max:255'],
            'contact' => ['required',  'max:255'],
        ]);

        //start transaction
        DB::beginTransaction();
        try {
            $company = $this->model->find($id);

            $this->model->update($request->all(), $id);

            DB::commit();
            //end transaction
            return to_route('companies.index')->with('success', 'Company '.$company->name.' updated successfully.');
        } catch (\Throwable $th) {
            DB::rollback();

            return to_route('companies.index')->with('error', 'Error updating company. '.$th->getMessage());
        }
    }
}
