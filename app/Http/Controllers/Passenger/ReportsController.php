<?php

namespace App\Http\Controllers\Passenger;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function index()
    {
        // Logic to fetch and display reports
        $reports = Report::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->latest()
            ->get();
        return view('passenger.reports', compact('reports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        Report::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Report submitted successfully!');
    }

    public function show($id)
    {
        $report = Report::findOrFail($id);

        $data = [
            'title' => $report->title,
            'description' => $report->description,
            'created_at' => $report->created_at->format('Y-m-d H:i:s'),
        ];
        
        // Check if the report belongs to the authenticated user
        if ($report->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        return view('passenger.report_detail', compact('report'));
    }

    public function destroy(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        if ($report->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $report->delete();
        return redirect()->back()->with('success', 'Report deleted successfully!');
    }

}
