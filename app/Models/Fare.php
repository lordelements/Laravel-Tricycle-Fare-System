<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fare extends Model
{
        protected $fillable = [
                'base_fare',
                'per_km_rate',
                'base_distance_km',
                'currency',
        ];
        protected $casts = [
                'base_fare' => 'float',
                'per_km_rate' => 'float',
                'base_distance_km' => 'float',
                'currency' => 'string',
        ];
        protected $table = 'fares';
        protected $primaryKey = 'id';

        public function tripRequests()
        {
                return $this->hasMany(TripRequest::class);
        }
        public function calculateFare($distance)
        {
                if ($distance <= $this->base_distance_km) {
                        return $this->base_fare;
                }

                $additionalDistance = $distance - $this->base_distance_km;
                return $this->base_fare + ($additionalDistance * $this->per_km_rate);
        }
}
// This model represents the fare structure for trips, including base fare, per kilometer rate, and base distance.
// It also includes methods to calculate the fare based on the distance of a trip.