<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Stylist;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\StylistSchedule;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function home()
    {
        $location = Location::all();
        $category = ServiceCategory::all();
        $service1 = Service::where('category_id', 3)->get();
        $service2 = Service::where('category_id', 4)->get();
    
        // Fetch all stylists initially
        $stylists = Stylist::all();
    
        return view('client.home', [
            'location' => $location,
            'category' => $category,
            'service1' => $service1,
            'service2' => $service2,
            'stylists' => $stylists, // Include the stylists in the view
        ]);
    }


    public function getStylists(Request $request, $locationId, $serviceId)
    {
        $stylists = Stylist::whereHas('locations', function ($query) use ($locationId) {
            $query->where('locations.id', $locationId);
        })->whereHas('services', function ($query) use ($serviceId) {
            $query->where('services.id', $serviceId);
        })->get();

        return response()->json(['stylists' => $stylists]);
    }

    public function getSchedule(Request $request, $stylistId)
    {
        // Get the date from the request
        $date = $request->input('date');
    
        // Use Eloquent to fetch the stylist schedule from the database
        $stylistSchedule = StylistSchedule::where('stylist_id', $stylistId)
            ->first();
    
        // Return the booked and off_days along with a constant availability array
        return response()->json([
            'date' => $date,
            'availability' => [
                ['start' => $date . 'T10:00:00', 'end' => $date . 'T12:00:00'],
                // ... other available time slots ...
            ],
            'booked' => $stylistSchedule->booked ?? [],
            'offDays' => $stylistSchedule->off_days ?? [],
        ]);
    }
    
}
