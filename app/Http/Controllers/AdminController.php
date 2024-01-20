<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Stylist;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function home() {
        return view('admin.admin');
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
            Session::flash('message', 'New Location Added!');
        }

        return redirect('/dashboard/location');

    }

    public function stylist() {
        $stylist = Stylist::with('services')->get();
        $service = Service::with('stylists')->get();
        return view('admin.stylists', ['stylist' => $stylist, 'service' => $service]);
    }

    public function addStylist(Request $request) {

        if ($request->file('image')) {
            $photo = $request->file('image');
        
            // Generate a unique name for the image
            $newName = $request->display_name . '-' . now()->timestamp . '.' . $photo->getClientOriginalExtension();
        
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
        

        if($stylist) {
            Session::flash('status', 'success');
            Session::flash('message', 'New Stylist Added!');
        }

        return redirect('/dashboard/stylist');

    }

    public function category() {
        $category = ServiceCategory::all();
        return view('admin.categories', ['category' => $category]);
    }

    public function addCategory(Request $request) {

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
            $newName = $request->name . '-' . now()->timestamp . '.' . $photo->getClientOriginalExtension();
        
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
}
