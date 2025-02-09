<?php

namespace App\Http\Controllers;

use App\Models\DailyLog;
use App\Models\Employee;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        $employee = Employee::where('user_id', auth()->id())->first();
        if (!$employee) {
            return redirect()->route('dashboard')->with('error', 'You are not assigned as an employee.');
        }

        $dailyLogs = DailyLog::where('employee_id', $employee->id)
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('logs.index', compact('dailyLogs', 'employee'));
    }

    public function create()
    {
        return view('logs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'log' => 'required|string|max:2000'
        ]);

        $employee = Employee::where('user_id', auth()->id())->first();

        if (!$employee) {
            return redirect()->route('logs.index')->with('error', 'You cannot add logs without an employee profile.');
        }

        DailyLog::create([
            'employee_id' => $employee->id,
            'description' => $request->log,
            'status' => 'Pending'
        ]);

        return redirect()->route('logs.index')->with('success', 'Log added successfully.');
    }

    public function verifyLogs()
    {
        $employee = Employee::where('user_id', auth()->id())->first();
    
        if (!$employee) {
            return redirect()->route('dashboard')->with('error', 'You are not assigned as an employee.');
        }
    
        // Fetch logs of subordinates (ensure this query is correct)
        $subordinateLogs = DailyLog::whereHas('employee', function ($query) use ($employee) {
            $query->where('supervisor_id', $employee->id);
        })->where('status', 'Pending')->get();
    
        return view('logs.verify', compact('subordinateLogs'));
    }
    
    public function approve(DailyLog $log)
    {
        $user = auth()->user();

        // Ensure only supervisors or admins can approve logs
        if (!$user->isSupervisor() && !$user->isAdmin()) {
            return back()->with('error', 'You do not have permission to approve logs.');
        }

        if ($log->status !== 'Pending') {
            return back()->with('error', 'This log has already been processed.');
        }

        $log->update(['status' => 'Approved']);
        return back()->with('success', 'Log approved.');
    }

    public function reject(DailyLog $log)
    {
        $user = auth()->user();

        // Ensure only supervisors or admins can reject logs
        if (!$user->isSupervisor() && !$user->isAdmin()) {
            return back()->with('error', 'You do not have permission to reject logs.');
        }

        if ($log->status !== 'Pending') {
            return back()->with('error', 'This log has already been processed.');
        }

        $log->update(['status' => 'Rejected']);
        return back()->with('success', 'Log rejected.');
    }
}
