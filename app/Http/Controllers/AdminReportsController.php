<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminReportsController extends Controller
{
    public function index()
    {
        // Fetch all reports with eager loading of the User model to avoid N+1 query problem
        $reports = Report::with('user')
                        ->orderBy('created_at', 'desc')
                        ->paginate(5);

        $reportsCount = $reports->total();

        return view('admin.reports.users_reports', compact('reports', 'reportsCount'));
    }

    public function edit(Report $report)
    {
        $report->loadMissing('user');
        return view('admin.reports.update_report', compact('report'));
    }

    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);
       
        $request->validate([
            'status' => 'required|in:pending,resolved,rejected',
        ]);

        $report->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.reports.table')->with('success', 'Report updated successfully!');
    }
   
    public function showPassengerReport(Report $report)
    {
        $report->loadMissing('user');
        return view('admin.reports.report_detail', compact('report'));
    }

    public function destroy(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $report->delete();
        return redirect()->back()->with('success', 'Report deleted successfully!');
    }

}