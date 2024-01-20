<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function home() {
        $location = Location::all();
        $category = ServiceCategory::all();
        $service1 = Service::where('category_id', 3)->get();
        $service2 = Service::where('category_id', 4)->get();
        return view('client.home', [
            'location' => $location,
            'category' => $category,
            'service1' => $service1,
            'service2' => $service2,
        ]);
    }
}
