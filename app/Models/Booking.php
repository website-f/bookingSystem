<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'booking_code', 'customer_id', 'service_id', 'stylist_id', 'location_id', 'date', 'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            // Extract the date from the date string
            $dateString = $booking->date;
        
            // Split the string into date and time parts
            $dateTimeParts = explode(', ', $dateString);
            // Extract the start date and time
            $startDate = str_replace('/', '-', $dateTimeParts[0]);
            $startTime = date('Y-m-d H:i:s', strtotime($startDate . ' ' . $dateTimeParts[1]));

            // Convert the date string to a Carbon instance
            $bookingDate = Carbon::parse($startTime);
        
            // Check if the booking date has already passed the current date
            if ($bookingDate->isPast()) {
                // Set the status to "complete"
                $booking->status = 'complete';
            }
        });
        
    }

    public function location() {
        return $this->belongsTo(Location::class);
    }
}
