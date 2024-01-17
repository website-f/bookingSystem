<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function home() {
        return view('admin.admin');
    }

    public function location() {
        $location = Location::all();
        return view('admin.locations', ['location' => $location]);
    }

    public function Addlocation(Request $request) {

        if ($request->file('image')) {
            $photo = $request->file('image');
        
            // Generate a unique name for the image
            $newName = $request->name . '-' . now()->timestamp . '.' . $photo->getClientOriginalExtension();
        
            // Set the path where you want to store the image in the public directory
            $path = public_path('photo/' . $newName);
        
            // Move the uploaded file to the specified path
            $photo->move(public_path('photo'), $newName);
        
            // Save the path to the database
            $fullpath = 'photo/' . $newName;

            $location = new Location;
            $location->name = $request->name;
            $location->full_address = $request->full_address;
            $location->image = $fullpath;
            $location->status = "Active";
            $location->save();
        } else {
            $location = new Location;
            $location->name = $request->name;
            $location->full_address = $request->full_address;
            $location->status = "Active";
            $location->save();
        }
        

        if($location) {
            Session::flash('status', 'success');
            Session::flash('message', 'New Location Added!');
        }

        return redirect('/dashboard/location');

    }
}
