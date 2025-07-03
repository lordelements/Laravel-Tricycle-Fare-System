<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fare;
use App\Models\User;
use App\Models\Report;
use App\Models\AuditTrail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class FareTableController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        // Fetch total reports
        $reportsCount = Report::count();
        $totalUsers = User::count();
        $totalUsersAdmin = User::where('usertype', 'admin')->count();
        $totalUsersPassenger = User::where('usertype', 'passenger')->count();
        $totalUsersDriver = User::where('usertype', 'driver')->count();

        // Fetch pending and resolved reports
        $pendingReportsCount = Report::where('status', 'pending')->count();
        $resolvedReportsCount = Report::where('status', 'resolved')->count();

        $totalUsersLogs = AuditTrail::count();

        return view('admin.index', compact(
            'reportsCount',
            'totalUsers',
            'totalUsersAdmin',
            'totalUsersPassenger',
            'totalUsersDriver',
            'pendingReportsCount',
            'resolvedReportsCount',
            'totalUsersLogs'
        ));
    }

    public function faretable()
    {
        $fares = Fare::latest()->get();
        $faresCount = $fares->count(); // Get the total count of fares
        return view('admin.faretable', compact('fares', 'faresCount'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'base_fare' => 'required|numeric|min:0',
            'per_km_rate' => 'required|numeric|min:0',
            'base_distance_km' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
        ]);

        Fare::create($request->all());
        

        return redirect()->route('admin.faretable')->with('success', 'Fare rate added successfully.');
    }

    public function destroy(Request $request, $id)
    {
        $fare = Fare::findOrFail($id);
        $fare->delete();

        if ($fare) {
            return redirect()->route('admin.faretable')->with('success', 'Fare rate deleted successfully.');
        }else {
            return Redirect::back()->withErrors(['error' => 'Failed to delete fare rate.']);
        }
        
    }
}
