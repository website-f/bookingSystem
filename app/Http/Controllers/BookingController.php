<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\Stylist;
use App\Models\Customer;
use App\Models\Location;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\StylistSchedule;
use App\Mail\SubmitNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function home()
    {
        $location = Location::all();
        $category = ServiceCategory::all();
        // $service1 = Service::where('category_id', 1)->get();
        // $service2 = Service::where('category_id', 2)->get();
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
    
        // Check if stylist schedule is found
    if ($stylistSchedule) {
        // Return the booked and off_days along with a constant availability array
        return response()->json([
            'date' => $date,
            'availability' => [
                ['start' => $date . 'T10:00:00', 'end' => $date . 'T12:00:00'],
                // ... other available time slots ...
            ],
            'booked' => $stylistSchedule->booked ? json_decode($stylistSchedule->booked, true) : [],
            'offDays' => $stylistSchedule->off_days ?? [],
        ]);
    } else {
        // Stylist schedule not found, return an empty response or handle it accordingly
        return response()->json([
            'date' => $date,
            'availability' => [],
            'booked' => [],
            'offDays' => [],
        ]);
    }
    }

    public function bookAppointment(Request $request) {
        $first_name = $request->fname;
        $last_name = $request->lname;
        $email = $request->email;
        $phone = $request->phone;
        $customerId = "";

        $customer = Customer::where('first_name', $first_name)
                            ->where('last_name', $last_name)
                            ->where('email', $email)
                            ->where('phone', $phone)->first();
        if ($customer) {
            $customerId = $customer->id;
        } else {
            $customer = new Customer;
            $customer->first_name = $first_name;
            $customer->last_name = $last_name;
            $customer->email = $email;
            $customer->phone = $phone;
            $customer->save();

            $customerId = $customer->id;
        }

        $bookingCode = strtoupper(Str::random(3)) . mt_rand(100, 999);
        $serviceId = $request->serviceDetailsId;
        $stylistId = $request->stylistId;
        $locationId = $request->location;
        $date = $request->datetime;
        $booked = $this->parseBookedString($date);
        $status = "active";
        $comments = $request->comments;

        // Check if a StylistSchedule already exists for the given stylist and date
        $stylistSchedule = StylistSchedule::where('stylist_id', $stylistId)
        ->first();

        if ($stylistSchedule) {
            // Retrieve the current off days
            $currentBoooked = json_decode($stylistSchedule->booked, true);

            if ($currentBoooked !== null) {
                // Merge the current off days with the new off days
                $mergedBooked = array_merge($currentBoooked, $booked);
            
                // Update the existing StylistSchedule
                $stylistSchedule->update([
                    'booked' => json_encode($mergedBooked), // Convert the merged array to JSON
                ]);
            } else {
                $stylistSchedule->update([
                    'booked' => $booked, // Convert the merged array to JSON
                ]);
            }
        
        } else {
            // Create a new StylistSchedule instance
            $stylistSchedule = new StylistSchedule([
                'stylist_id' => $stylistId,
                'booked' => json_encode($booked),
            ]);
        
            // Save the data to the database
            $stylistSchedule->save();
        }

        $booking = new Booking;
        $booking->booking_code = $bookingCode;
        $booking->customer_id = $customerId;
        $booking->service_id = $serviceId;
        $booking->stylist_id = $stylistId;
        $booking->location_id = $locationId;
        $booking->date = json_encode($date);
        $booking->status = $status;
        $booking->comments = $comments;
        $booking->save();

        $locationEmail = Location::where('id', $locationId)->first();
        $serviceEmail = Service::where('id', $serviceId)->first();
        $stylistEmail = Stylist::where('id', $stylistId)->first();
        $fullname = $first_name . $last_name;

        Mail::to($email)->send(new SubmitNotification($bookingCode, 
                                                      $locationEmail->name, 
                                                      $date, 
                                                      $serviceEmail->name, 
                                                      $stylistEmail->display_name,
                                                      $fullname,
                                                      $phone ));

        return redirect("/thankyou/" . $booking->id);


    }

    private function parseBookedString($bookedString)
{
    $booked = [];

    // Split the string into date and time parts
    list($datePart, $timePart) = explode(' , ', $bookedString);

    // Format date as 'Y-m-d'
    $formattedDate = date('n-d-Y', strtotime(str_replace('/', '-', $datePart)));

    // Split the time range into start and end times
    list($startTime, $endTime) = explode(' - ', $timePart);

    // Create the time slot in the desired format
    $booked[] = [
        'start' => $formattedDate . 'T' . date('H:i:s', strtotime($startTime)),
        'end' => $formattedDate . 'T' . date('H:i:s', strtotime($endTime)),
    ];

    return $booked;
}


    public function thankyou($id) {
        $booking = Booking::findOrFail($id);
        return view('client.thankyou', ['booking' => $booking]);
    }
    
}
