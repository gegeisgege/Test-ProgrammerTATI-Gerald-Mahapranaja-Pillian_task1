<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function show(Employee $employee)
    {
        $logs = $employee->dailyLogs ?? collect();
        return view('employees.show', compact('employee', 'logs'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'supervisor_id' => 'nullable|integer|exists:employees,id', // Adjust validation as needed
        ]);
    
        Employee::create($request->all());
    
        return redirect()->route('employee.index')->with('success', 'Employee added successfully.');
    }
    
    
}
