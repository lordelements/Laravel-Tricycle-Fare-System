<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fare;
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
        return view('admin.index');
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
        
        // dd($request->all());


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
