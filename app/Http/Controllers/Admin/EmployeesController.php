<?php

namespace App\Http\Controllers\Admin;

use App\Entity\CurrentEmployee;
use App\Entity\CurrentEmployeeInterface;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Organisation;
use App\Models\User;
use App\Services\Employee\EmployeeService;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(EmployeeService $employeeService )
    {
        $employees = Employee::all();
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        $organisations = Organisation::orderBy('name')->get();
        $title = "Add Employee";

        return view('admin.employees.create', [
            'users' => $users,
            'title' => $title,
            'organisations' => $organisations,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'position' => 'required',
            'organisation_id' => 'required|exists:organisations,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $employee = Employee::create($validatedData);
        return redirect()->route('admin.employees.index')->with('success', 'Employee has been added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
