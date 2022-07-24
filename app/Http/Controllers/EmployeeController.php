<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Repositories\CommonRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Employee $employee)
    {
        parent::__construct();
        // set the model
        $this->model = new CommonRepository($employee);
    }

    /*
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Employee/Create');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //start transaction
        DB::beginTransaction();
        try {
            $employee = $this->model->find($id);
            $this->model->delete($id);
            DB::commit();
            //end transaction
            return to_route('employees.index')->with('success', 'Employee '.$employee->name.' deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollback();

            return to_route('employees.index')->with('error', 'Error deleting employee. '.$th->getMessage());
        }
    }

    /*
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $employee = $this->model->find($id);

            return Inertia::render('Employee/Edit', [
                'employee' => $employee,
            ]);
        } catch (\Throwable $th) {
            return to_route('employees.index')->with('error', 'Error creating employee. '.$th->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employees = $this->model->getModel()->when($request->q, function ($query, $q) {
            $query->where('name', 'LIKE', '%'.$q.'%');
            $query->Orwhere('employee_number', $q);
            $query->Orwhere('email', 'LIKE', '%'.$q.'%');
        })->orderBy('id', 'desc')->paginate(10);

        return Inertia::render('Employee/Index', [
            'employees' => $employees,
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
            'employee_number' => ['required', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:employees'],
            'contact' => ['required', 'max:255'],
            'designation' => ['required', 'max:255'],
        ]);

        //start transaction
        DB::beginTransaction();
        try {
            $create = $this->model->create($request->all());

            DB::commit();
            //end transaction
            return to_route('employees.index')->with('success', 'Employee '.$create->name.' created successfully.');
        } catch (\Throwable $th) {
            DB::rollback();

            return to_route('employees.index')->with('error', 'Error creating employee. '.$th->getMessage());
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
            'employee_number' => ['required', 'max:255'],
            'email' => 'unique:employees,email,'.$id,
            'contact' => ['required', 'max:255'],
            'designation' => ['required', 'max:255'],
        ]);

        //start transaction
        DB::beginTransaction();
        try {
            $employee = $this->model->find($id);

            $this->model->update($request->all(), $id);
            DB::commit();
            //end transaction
            return to_route('employees.index')->with('success', 'Employee '.$employee->name.' updated successfully.');
        } catch (\Throwable $th) {
            DB::rollback();

            return to_route('employees.index')->with('error', 'Error updating employee. '.$th->getMessage());
        }
    }
}
