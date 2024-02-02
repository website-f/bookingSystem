<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Stylist;
use App\Models\Customer;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\StylistSchedule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function home() {
        $bookings = Booking::all();
        $locations = Location::all();
        $stylists = Stylist::all();
        $services = Service::all();
        $customers = Customer::all();
        return view('admin.admin', ['bookings' => $bookings,
                                    'locations' => $locations,
                                    'stylists' => $stylists,
                                    'services' => $services,
                                    'customers' => $customers
        ]);
    }

    public function location() {
        $location = Location::with('stylists')->get();
        $stylists = Stylist::with('services')->get();
        $service = Service::all();
        return view('admin.locations', ['location' => $location,
                                        'stylists' => $stylists,
                                        'service' => $service]);
    }

    public function Addlocation(Request $request) {

        if ($request->file('image')) {
            $photo = $request->file('image');
        
            // Generate a unique name for the image
            $newName = now()->timestamp . '.' . $photo->getClientOriginalExtension();
        
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
            $location->save();
            if ($request->has('stylists')) {
                $stylists = $request->input('stylists');
            
                // Synchronize the stylists and services for the location
                $location->stylists()->sync($stylists);
            }
  
        } else {
            $location = new Location;
            $location->name = $request->name;
            $location->full_address = $request->full_address;
            $location->save();
            if ($request->has('stylists')) {
                $stylists = $request->input('stylists');
            
                // Synchronize the stylists and services for the location
                $location->stylists()->sync($stylists);
            }
            
            
        }
        

        if($location) {
            Session::flash('status', 'success');
            Session::flash('message', 'New Location Added!');
        }

        return redirect('/dashboard/location');

    }

    public function Editlocation(Request $request, $id) {

        if ($request->file('image')) {
            $photo = $request->file('image');
        
            // Generate a unique name for the image
            $newName = now()->timestamp . '.' . $photo->getClientOriginalExtension();
        
            // Set the path where you want to store the image in the public directory
            $path = public_path('photo/' . $newName);
        
            // Move the uploaded file to the specified path
            $photo->move(public_path('photo'), $newName);
        
            // Save the path to the database
            $fullpath = 'photo/' . $newName;

            $location = Location::findOrFail($id);
            $location->name = $request->name;
            $location->full_address = $request->full_address;
            $location->image = $fullpath;
            $location->save();
            if ($request->has('stylists')) {
                $stylists = $request->input('stylists');
            
                // Synchronize the stylists and services for the location
                $location->stylists()->sync($stylists);
            }
  
        } else {
            $location = Location::findOrFail($id);
            $location->name = $request->name;
            $location->full_address = $request->full_address;
            $location->save();
            if ($request->has('stylists')) {
                $stylists = $request->input('stylists');
            
                // Synchronize the stylists and services for the location
                $location->stylists()->sync($stylists);
            }
            
            
        }
        

        if($location) {
            Session::flash('status', 'success');
            Session::flash('message', 'Successfully Edited');
        }

        return redirect('/dashboard/location');

    }

    public function stylist() {
        $stylist = Stylist::with('services')->get();
        $service = Service::with('stylists')->get();
        $stylistSchedule = StylistSchedule::all();
        return view('admin.stylists', ['stylist' => $stylist, 'service' => $service, 'stylistSchedule' => $stylistSchedule]);
    }

    public function addStylist(Request $request) {

        if ($request->file('image')) {
            $photo = $request->file('image');
        
            // Generate a unique name for the image
            $newName = now()->timestamp . '.' . $photo->getClientOriginalExtension();
        
            // Set the path where you want to store the image in the public directory
            $path = public_path('photo/' . $newName);
        
            // Move the uploaded file to the specified path
            $photo->move(public_path('photo'), $newName);
        
            // Save the path to the database
            $fullpath = 'photo/' . $newName;

            $stylist = new Stylist;
            $stylist->first_name = $request->first_name;
            $stylist->last_name = $request->last_name;
            $stylist->display_name = $request->display_name;
            $stylist->title = $request->title;
            $stylist->bio = $request->bio;
            $stylist->email = $request->email;
            $stylist->image = $fullpath;
            $stylist->save();
        } else {
            $stylist = new Stylist;
            $stylist->first_name = $request->first_name;
            $stylist->last_name = $request->last_name;
            $stylist->display_name = $request->display_name;
            $stylist->title = $request->title;
            $stylist->bio = $request->bio;
            $stylist->email = $request->email;
            $stylist->save();

        }

        $offDaysString = $request->input('off_days');

        $offDays = $this->parseOffDaysString($offDaysString);

        $stylistSchedule = StylistSchedule::where('stylist_id', $stylist->id)->first();
    
        if ($stylistSchedule) {
            // Retrieve the current off days
            $currentOffDays = json_decode($stylistSchedule->off_days, true);
        
            // Merge the current off days with the new off days
            $mergedOffDays = array_merge($currentOffDays, $offDays);
        
            // Update the existing StylistSchedule
            $stylistSchedule->update([
                'off_days' => json_encode($mergedOffDays), // Convert the merged array to JSON
            ]);
        } else {
            // Create a new StylistSchedule instance
            $stylistSchedule = new StylistSchedule([
                'stylist_id' => $stylist->id,
                'off_days' => json_encode($offDays),
            ]);
    
            // Save the data to the database
            $stylistSchedule->save();
        }
        

        if($stylist) {
            Session::flash('status', 'success');
            Session::flash('message', 'New Stylist Added!');
        }

        return redirect('/dashboard/stylist');

    }

    public function editStylist(Request $request, $id) {

        if ($request->file('image')) {
            $photo = $request->file('image');
        
            // Generate a unique name for the image
            $newName = now()->timestamp . '.' . $photo->getClientOriginalExtension();
        
            // Set the path where you want to store the image in the public directory
            $path = public_path('photo/' . $newName);
        
            // Move the uploaded file to the specified path
            $photo->move(public_path('photo'), $newName);
        
            // Save the path to the database
            $fullpath = 'photo/' . $newName;

            $stylist = Stylist::findOrFail($id);
            $stylist->first_name = $request->first_name;
            $stylist->last_name = $request->last_name;
            $stylist->display_name = $request->display_name;
            $stylist->title = $request->title;
            $stylist->bio = $request->bio;
            $stylist->email = $request->email;
            $stylist->image = $fullpath;
            $stylist->save();
        } else {
            $stylist = Stylist::findOrFail($id);
            $stylist->first_name = $request->first_name;
            $stylist->last_name = $request->last_name;
            $stylist->display_name = $request->display_name;
            $stylist->title = $request->title;
            $stylist->bio = $request->bio;
            $stylist->email = $request->email;
            $stylist->save();

        }

        $offDaysString = $request->input('off_days');
        $offDays = "";

        if ($offDaysString) {
            $offDays = $this->parseOffDaysString($offDaysString);
        } else {
            $offDays = [];
        }

        $stylistSchedule = StylistSchedule::where('stylist_id', $id)->first();
    
        if ($stylistSchedule) {
            // Retrieve the current off days
            $currentOffDays = json_decode($stylistSchedule->off_days, true);
            $mergedOffDays = "";

            if ($currentOffDays !== null) {
                // Merge the current off days with the new off days
                $mergedOffDays = array_merge($currentOffDays, $offDays);
            } else {
                $mergedOffDays = [];
            }
     
        
            // Update the existing StylistSchedule
            $stylistSchedule->update([
                'off_days' => json_encode($mergedOffDays), // Convert the merged array to JSON
            ]);
        } else {
            // Create a new StylistSchedule instance
            $stylistSchedule = new StylistSchedule([
                'stylist_id' => $stylist->id,
                'off_days' => json_encode($offDays),
            ]);
    
            // Save the data to the database
            $stylistSchedule->save();
        }
        

        if($stylist) {
            Session::flash('status', 'success');
            Session::flash('message', 'Successfully Edited');
        }

        return redirect('/dashboard/stylist');

    }

    public function removeStylist($id) {
        $stylist = Stylist::findOrFail($id);
        $stylist->services()->detach();
        $stylist->locations()->detach();
        $stylist->delete();

        if($stylist) {
            Session::flash('status', 'success');
            Session::flash('message', 'Successfully Deleted');
        }

        return redirect('/dashboard/stylist');

    }

    private function parseOffDaysString($offDaysString)
    {
        $offDays = [];
    
        // Convert the off_days string to an array
        $offDaysArray = explode(',', $offDaysString);
    
        // Format each off day and add it to the offDays array
        foreach ($offDaysArray as $offDay) {
            $formattedOffDay = date('n-j-Y', strtotime($offDay));
            $offDays[] = $formattedOffDay;
        }
    
        return $offDays;
    }

    public function removeOffday(Request $request)
    {
        $stylistId = $request->input('stylistId');
        $offday = $request->input('offday');
    
        // Retrieve the stylist schedule
        $stylistSchedule = StylistSchedule::where('stylist_id', $stylistId)->first();
    
        if ($stylistSchedule) {
            // Remove the off-day from the array
            $offDays = json_decode($stylistSchedule->off_days, true);
            $offDays = array_diff($offDays, [$offday]);
    
            // Update the stylist schedule
            $stylistSchedule->update([
                'off_days' => json_encode(array_values($offDays)),
            ]);
    
            return response()->json(['message' => 'Off-day removed successfully']);
        }
    
        return response()->json(['error' => 'Stylist schedule not found'], 404);
    }

    public function category() {
        $category = ServiceCategory::all();
        return view('admin.categories', ['category' => $category]);
    }

    public function addCategory(Request $request) {

        if ($request->file('image')) {
            $photo = $request->file('image');
        
            // Generate a unique name for the image
            $newName = now()->timestamp . '.' . $photo->getClientOriginalExtension();
        
            // Set the path where you want to store the image in the public directory
            $path = public_path('photo/' . $newName);
        
            // Move the uploaded file to the specified path
            $photo->move(public_path('photo'), $newName);
        
            // Save the path to the database
            $fullpath = 'photo/' . $newName;

            $category = new ServiceCategory;
            $category->name = $request->name;
            $category->image = $fullpath;
            $category->save();
        } else {
            $category = new ServiceCategory;
            $category->name = $request->name;
            $category->save();

        }
        

        if($category) {
            Session::flash('status', 'success');
            Session::flash('message', 'New Category Added!');
        }

        return redirect('/dashboard/service-categories');

    }

    public function editCategory(Request $request, $id) {

        if ($request->file('image')) {
            $photo = $request->file('image');
        
            // Generate a unique name for the image
            $newName = now()->timestamp . '.' . $photo->getClientOriginalExtension();
        
            // Set the path where you want to store the image in the public directory
            $path = public_path('photo/' . $newName);
        
            // Move the uploaded file to the specified path
            $photo->move(public_path('photo'), $newName);
        
            // Save the path to the database
            $fullpath = 'photo/' . $newName;

            $category = ServiceCategory::findOrFail($id);
            $category->name = $request->name;
            $category->image = $fullpath;
            $category->save();
        } else {
            $category = ServiceCategory::findOrFail($id);
            $category->name = $request->name;
            $category->save();

        }
        

        if($category) {
            Session::flash('status', 'success');
            Session::flash('message', 'Successfully Edited');
        }

        return redirect('/dashboard/service-categories');

    }

    public function service() {
        $service = Service::with('stylists')->get();
        $stylists = Stylist::with('services')->get();
        $category = ServiceCategory::all();
        return view('admin.services', ['service' => $service, 'stylists' => $stylists, 'category' => $category]);
    }

    public function addService(Request $request) {

        if ($request->file('image')) {
            $photo = $request->file('image');
        
            // Generate a unique name for the image
            $newName = now()->timestamp . '.' . $photo->getClientOriginalExtension();
        
            // Set the path where you want to store the image in the public directory
            $path = public_path('photo/' . $newName);
        
            // Move the uploaded file to the specified path
            $photo->move(public_path('photo'), $newName);
        
            // Save the path to the database
            $fullpath = 'photo/' . $newName;

            $service = new Service;
            $service->name = $request->name;
            $service->short_description = $request->short_description;
            $service->price_min = $request->price_min;
            $service->price_max = $request->price_max;
            $service->charge_amount = $request->charge_amount;
            $service->duration = $request->duration;
            $service->category_id = $request->category_id;
            $service->status = 'active';
            $service->selection_image = $fullpath;
            $service->save();
            if ($request->has('stylists')) {
                $stylists = $request->input('stylists');
            
                // Synchronize the stylists and services for the location
                $service->stylists()->sync($stylists);
            }
        } else {
            $service = new Service;
            $service->name = $request->name;
            $service->short_description = $request->short_description;
            $service->price_min = $request->price_min;
            $service->price_max = $request->price_max;
            $service->charge_amount = $request->charge_amount;
            $service->duration = $request->duration;
            $service->category_id = $request->category_id;
            $service->status = 'active';
            $service->save();
            if ($request->has('stylists')) {
                $stylists = $request->input('stylists');
            
                // Synchronize the stylists and services for the location
                $service->stylists()->sync($stylists);
            }

        }
        

        if($service) {
            Session::flash('status', 'success');
            Session::flash('message', 'New Service Added!');
        }

        return redirect('/dashboard/service');

    }

    public function editService(Request $request, $id) {

        if ($request->file('image')) {
            $photo = $request->file('image');
        
            // Generate a unique name for the image
            $newName = now()->timestamp . '.' . $photo->getClientOriginalExtension();
        
            // Set the path where you want to store the image in the public directory
            $path = public_path('photo/' . $newName);
        
            // Move the uploaded file to the specified path
            $photo->move(public_path('photo'), $newName);
        
            // Save the path to the database
            $fullpath = 'photo/' . $newName;

            $service = Service::findOrFail($id);
            $service->name = $request->name;
            $service->short_description = $request->short_description;
            $service->price_min = $request->price_min;
            $service->price_max = $request->price_max;
            $service->charge_amount = $request->charge_amount;
            $service->duration = $request->duration;
            $service->category_id = $request->category_id;
            $service->status = 'active';
            $service->selection_image = $fullpath;
            $service->save();
            if ($request->has('stylists')) {
                $stylists = $request->input('stylists');
            
                // Synchronize the stylists and services for the location
                $service->stylists()->sync($stylists);
            }
        } else {
            $service = Service::findOrFail($id);
            $service->name = $request->name;
            $service->short_description = $request->short_description;
            $service->price_min = $request->price_min;
            $service->price_max = $request->price_max;
            $service->charge_amount = $request->charge_amount;
            $service->duration = $request->duration;
            $service->category_id = $request->category_id;
            $service->status = 'active';
            $service->save();
            if ($request->has('stylists')) {
                $stylists = $request->input('stylists');
            
                // Synchronize the stylists and services for the location
                $service->stylists()->sync($stylists);
            }

        }
        

        if($service) {
            Session::flash('status', 'success');
            Session::flash('message', 'New Service Added!');
        }

        return redirect('/dashboard/service');

    }

    public function removeService($id) {
        $service = Service::findOrFail($id);
        $service->stylists()->detach();
        $service->delete();

        if($service) {
            Session::flash('status', 'success');
            Session::flash('message', 'Successfully Deleted');
        }

        return redirect('/dashboard/service');

    }

    public function users() {
        $users = User::all();
        return view('admin.users', ['users' => $users]);
    }
}
