<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Repositories\CommonRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    // space that we can use the repository from
    protected $model;

    protected $company;

    public function __construct(Department $department, Company $company)
    {
        parent::__construct();
        // set the model
        $this->model = new CommonRepository($department);
        $this->company = new CommonRepository($company);
    }

    /*
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = $this->company->all();

        return Inertia::render('Department/Create', [
            'companies' => $companies,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //start transaction
        DB::beginTransaction();
        try {
            //check foreign key from   child table
            $employee = Employee::query()
                ->where('department_id', $id)
                ->count();
            if ($employee < 1) {
                $department = $this->model->find($id);
                $this->model->delete($id);
                DB::commit();
                //end transaction
                return to_route('departments.index')->with('success', 'Department '.$department->name.' deleted successfully.');
            } else {
                return to_route('departments.index')->with('error', 'Company data in use . Unable to delete.');
            }
        } catch (\Throwable $th) {
            DB::rollback();

            return to_route('departments.index')->with('error', 'Error deleting department. '.$th->getMessage());
        }
    }

    /*
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $data['department'] = $this->model->find($id);
            $data['companies'] = $this->company->all();

            return Inertia::render('Department/Edit', $data);
        } catch (\Throwable $th) {
            return to_route('departments.index')->with('error', 'Error creating user. '.$th->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $departments = $this->model->getModel()->when($request->q, function ($query, $q) {
            $query->where('name', 'LIKE', '%'.$q.'%');
            $query->where('company_id', $q);
        })->orderBy('id', 'desc')
            ->with('company')
            ->paginate(10);

        return Inertia::render('Department/Index', [
            'departments' => $departments,
        ]);
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //check form validation rule
        $this->validate($request, [
            'company_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        //start transaction
        DB::beginTransaction();
        try {
            $create = $this->model->create($request->all());

            DB::commit();
            //end transaction
            return to_route('departments.index')->with('success', 'Department '.$create->name.' created successfully.');
        } catch (\Throwable $th) {
            DB::rollback();

            return to_route('departments.index')->with('error', 'Error creating department. '.$th->getMessage());
        }
    }

    /*
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //check form validation rule
        $this->validate($request, [
            'company_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        //start transaction
        DB::beginTransaction();
        try {
            $department = $this->model->find($id);

            $this->model->update($request->all(), $id);
            DB::commit();
            //end transaction
            return to_route('departments.index')->with('success', 'Company '.$department->name.' updated successfully.');
        } catch (\Throwable $th) {
            DB::rollback();

            return to_route('departments.index')->with('error', 'Error updating company. '.$th->getMessage());
        }
    }
}
