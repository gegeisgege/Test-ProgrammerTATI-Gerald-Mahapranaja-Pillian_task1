<?php

use App\Models\DailyLog;
use Illuminate\Http\Request;

class DailyLogController extends Controller
{
    public function approve($id)
    {
        $log = DailyLog::findOrFail($id);
        $log->status = 'approved';
        $log->save();

        return redirect()->back()->with('success', 'Log approved successfully.');
    }

    public function reject($id)
    {
        $log = DailyLog::findOrFail($id);
        $log->status = 'rejected';
        $log->save();

        return redirect()->back()->with('error', 'Log rejected.');
    }
}
