<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AuditTrailController extends Controller
{
    public function showAuditTrails()
    {
        $query = AuditTrail::with('user');
        // $auditTrails = AuditTrail::with('user')->orderBy('created_at', 'desc')->get()->paginate(5);
        $auditTrails = $query->latest()->paginate(5);
        return view('admin.audit_trails.users_logs', compact('auditTrails'));
    }

    public function deleteLogs(Request $request) {
        $auditTrails = AuditTrail::findOrFail($request->input('user_id'));
        $auditTrails->delete();
        
        if ($auditTrails) {
            return Redirect::to('/dashboard/users/logs')->with('success', 'User logs activity deleted successfully!');
        } else {
            return Redirect::back()->withErrors(['error' => 'Failed to delete users logs activity.']);
        }
    }

}
