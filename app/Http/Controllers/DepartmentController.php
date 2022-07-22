<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    /*
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Department/Create');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //start transaction
        DB::beginTransaction();
        try {
            $department = Department::findOrFail($id);
            $department->delete();
            DB::commit();
            //end transaction
            return to_route('departments.index')->with('success', 'Department ' . $department->name . ' deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return to_route('departments.index')->with('error', 'Error deleting department. ' . $th->getMessage());
        }
    }

    /*
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $department = Department::findOrFail($id);
            return Inertia::render('Department/Edit', [
                'department' => $department
            ]);
        } catch (\Throwable $th) {
            return to_route('departments.index')->with('error', 'Error creating user. ' . $th->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $departments = Department::when($request->q, function ($query, $q) {
            $query->where('name', 'LIKE', "%" . $q . "%");
        })->orderBy('id', 'desc')->paginate(10);

        return Inertia::render('Department/Index', [
            'departments' => $departments
        ]);
    }

    /**
     * Display a listing of user request data.
     */
    public function search(Request $request)
    {
        $departments = Company::where('name', 'like', '%' . $request->q . '%')->paginate(10);
        return response()->json($departments);
    }


    /*
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //check form validation rule
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255']
        ]);

        //start transaction
        DB::beginTransaction();
        try {
            $attributes = new Department($request->all());
            $attributes->save();

            DB::commit();
            //end transaction
            return to_route('departments.index')->with('success', 'Department ' . $attributes->name . ' created successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return to_route('departments.index')->with('error', 'Error creating department. ' . $th->getMessage());
        }
    }

    /*
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //check form validation rule
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255']
        ]);

        //start transaction
        DB::beginTransaction();
        try {
            $department = Company::findOrFail($id);
            $department->update([
                'name' => $request->name
            ]);
            DB::commit();
            //end transaction
            return to_route('departments.index')->with('success', 'Company ' . $department->name . ' updated successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return to_route('departments.index')->with('error', 'Error updating company. ' . $th->getMessage());
        }
    }
}
