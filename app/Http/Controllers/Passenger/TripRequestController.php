<?php

namespace App\Http\Controllers\Passenger;

use App\Models\Fare;
use App\Models\TripRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TripRequestController extends Controller
{
    /**
     * Ensure only authenticated users (passengers) can access.
     */
    public function __construct()
    {
        /* The line `->middleware(['auth', 'passenger:passenger']);` in the
        `TripRequestController` constructor is setting up middleware for the controller. */
        // $this->middleware(['auth', 'passenger:passenger']);
        $this->middleware('auth');
    }


    
    public function index()
    {
        $tripRequests = TripRequest::where('user_id', Auth::id())
            ->orderBy('timestamp', 'desc')
            ->get();

        // $tripRequests = TripRequest::latest()->paginate(5);
        return view('passenger.dashboard', compact('tripRequests'));
    }
    
    public function tripRequest()
    {
        $latestFare = Fare::latest()->first();
        return view('passenger.triprequest', compact('latestFare'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {

    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pickup' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'pickup_lat' => 'required|numeric',
            'pickup_lng' => 'required|numeric',
            'dest_lat' => 'required|numeric',
            'dest_lng' => 'required|numeric',
            'distance' => 'required|numeric',
            'estimated_price' => 'required|numeric',
        ]);

        $save = TripRequest::create([
            'user_id' => Auth::id(),
            'pickup_location' => $request->pickup,
            'destination' => $request->destination,
            'pickup_lat' => $request->pickup_lat,
            'pickup_lng' => $request->pickup_lng,
            'dest_lat' => $request->dest_lat,
            'dest_lng' => $request->dest_lng,
            'distance' => $request->distance,
            'estimated_price' => $request->estimated_price,
            'timestamp' => now(),
        ]);

        if ($save) {
            return Redirect('/trip-request')->with('success', 'Trip requested successfully.');
        }
        else {
            return Redirect('/trip-request')->withErrors(['error' => 'Failed to request trip.']);
        }

        
    }


    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     $tripRequests = TripRequest::where('user_id', Auth::id())
    //         ->orderBy('timestamp', 'desc')
    //         ->get();

    //     return view('passenger.dashboard', compact('tripRequests'));
    // }

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
    public function destroy(Request $request, $id)
    {
        $tripRequests = TripRequest::findOrFail($id);
        $tripRequests->delete();

        if ($tripRequests) {
            return Redirect('/dashboard/passenger')->with('success', 'Trip request deleted successfully.');
        } else {
            return Redirect('/dashboard/passenger')->withErrors(['error' => 'Failed to delete trip request.']);
        }
    }
}
