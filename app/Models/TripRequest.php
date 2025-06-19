<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripRequest extends Model
{
  public $timestamps = false;

  protected $fillable = [
    'user_id',
    'pickup_location',
    'destination',
    'timestamp',
    'fare_id',
    'calculated_fare',
    'estimated_price',
  ];

  public function fare()
  {
    return $this->belongsTo(Fare::class);
  }
}
