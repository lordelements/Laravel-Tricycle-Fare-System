<?php

use App\Models\AuditTrail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\FareController;
use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\AdminReportsController;
use App\Http\Controllers\Admin\FareTableController;
use App\Http\Controllers\Admin\UsersAcountController;
use App\Http\Controllers\Passenger\ReportsController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Passenger\TripRequestController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/Dashboard/admin/profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/Dashboard/admin/profile', [AdminProfileController::class, 'passwordUpdate'])->name('admin.password.update');
    Route::patch('/Dashboard/admin/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::delete('/Dashboard/admin/profile', [AdminProfileController::class, 'destroy'])->name('admin.profile.destroy');
});


// Passenger Routes
Route::middleware(['auth', 'verified', 'prevent-back', 'role:passenger'])->group(function () {
    Route::get('/dashboard/passenger', [TripRequestController::class, 'index'])->name('passenger.dashboard');
    Route::get('/trip-request', [TripRequestController::class, 'tripRequest'])->name('passenger.triprequest');
    Route::get('/trip-request/history/{id}', [TripRequestController::class, 'show'])->name('passenger.triprequest_history');
    Route::post('/trip-request', [TripRequestController::class, 'store'])->name('trip.store');
    Route::delete('/delete/trip-request/{id}', [TripRequestController::class, 'destroy'])->name('passenger.trip.delete');

    
    // Reports feedback 
    Route::get('/dashboard/reports', [ReportsController::class, 'index'])->name('passenger.reports');
    Route::get('/dashboard/reports/passenger/{id}', [ReportsController::class, 'show'])->name('reports.report_detail');
    Route::post('/dashboard/reports', [ReportsController::class, 'store'])->name('store.reports');
    Route::delete('/dashboard/reports/{id}', [ReportsController::class, 'destroy'])->name('delete.report');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'prevent-back', 'role:admin'])->group(function () {
    Route::get('/Dashboard', [FareTableController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/faretable', [FareTableController::class, 'faretable'])->name('admin.faretable');
    Route::delete('/dashboard/faretable/{id}', [FareTableController::class, 'destroy'])->name('admin.delete_fare.destroy');
    Route::post('/admin/fares', [FareTableController::class, 'store'])->name('admin.fare.store');
    Route::get('/fare/latest', [FareController::class, 'latest']);

    Route::get('/dashboard/users', [UsersAcountController::class, 'showUsers'])->name('admin.registeredUsers');
    Route::delete('/dashboard/delete_user/{id}', [UsersAcountController::class, 'destroy'])->name('admin.delete_user.destroy');
    Route::get('/dashboard/add_user', [UsersAcountController::class, 'create']);
    Route::post('/dashboard/add_user', [UsersAcountController::class, 'store'])->name('admin.register');
    Route::get('/dashboard/edit_account/{id}', [UsersAcountController::class, 'edit'])->name('admin.update_account');
    Route::put('/dashboard/edit_account/{id}', [UsersAcountController::class, 'update'])->name('admin.update');

    // Audit Trail | Users logs
    Route::get('/dashboard/users/logs', [AuditTrailController::class, 'showAuditTrails'])->name('admin.showAuditTrails');
    Route::delete('/dashboard/users/logs/{id}', [AuditTrailController::class, 'deleteLogs'])->name('delete_logs');

    // Admin Reports
    Route::get('/dashboard/users_reports', [AdminReportsController::class, 'index'])->name('admin.reports.table');
    Route::get('/reports/{report}', [AdminReportsController::class, 'showPassengerReport'])->name('show_passenger_report');
    Route::delete('/dashboard/reports/{id}', [AdminReportsController::class, 'destroy'])->name('delete.report');
    Route::get('/admin/reports/{report}/edit', [AdminReportsController::class, 'edit'])->name('admin.reports.edit');
    Route::patch('/admin/reports/{report}', [AdminReportsController::class, 'update'])->name('admin.reports.update');
    
});



require __DIR__.'/auth.php';
