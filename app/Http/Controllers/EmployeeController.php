<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class EmployeeController extends Controller
{
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
            $employee = Employee::findOrFail($id);
            $employee->delete();
            DB::commit();
            //end transaction
            return to_route('employees.index')->with('success', 'Employee ' . $employee->name . ' deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return to_route('employees.index')->with('error', 'Error deleting employee. ' . $th->getMessage());
        }
    }

    /*
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            return Inertia::render('Employee/Edit', [
                'employee' => $employee
            ]);
        } catch (\Throwable $th) {
            return to_route('employees.index')->with('error', 'Error creating employee. ' . $th->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employees = Employee::when($request->q, function ($query, $q) {
            $query->where('name', 'LIKE', "%" . $q . "%");
            $query->Orwhere('employee_number', $q);
            $query->Orwhere('email', 'LIKE', "%" . $q . "%");
        })->orderBy('id', 'desc')->paginate(10);

        return Inertia::render('Employee/Index', [
            'employees' => $employees
        ]);
    }

    /**
     * Display a listing of user request data.
     */
    public function search(Request $request)
    {
        $employees = Employee::where('name', 'like', '%' . $request->q . '%')->paginate(10);
        return response()->json($employees);
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
            'designation' => ['required', 'max:255']
        ]);

        //start transaction
        DB::beginTransaction();
        try {
            $attributes = new Employee($request->all());
            $attributes->save();

            DB::commit();
            //end transaction
            return to_route('employees.index')->with('success', 'Employee ' . $attributes->name . ' created successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return to_route('employees.index')->with('error', 'Error creating employee. ' . $th->getMessage());
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
            'designation' => ['required', 'max:255']
        ]);

        //start transaction
        DB::beginTransaction();
        try {
            $employee = Employee::findOrFail($id);
            $employee->update([
                'name' => $request->name,
                'employee_number' => $request->employee_number,
                'email' => $request->email,
                'contact' => $request->contact,
                'designation' => $request->designation
            ]);
            DB::commit();
            //end transaction
            return to_route('employees.index')->with('success', 'Employee ' . $employee->name . ' updated successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return to_route('employees.index')->with('error', 'Error updating employee. ' . $th->getMessage());
        }
    }
}
