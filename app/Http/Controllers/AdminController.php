<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Branch;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Stylist;
use App\Models\Customer;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\StylistSchedule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function home() {
        $bookings;
        $locations = Location::all();
        $stylists = Stylist::all();
        $services = Service::all();
        $customers = Customer::all();
        // Get the current month and year
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $currentDate = Carbon::now()->toDateString();
        
        // Get the first and last day of the current month
        $firstDayOfMonth = Carbon::now()->startOfMonth();
        $lastDayOfMonth = Carbon::now()->endOfMonth();
        $bookingsCountPerDay;

        if (Auth::user()->role_id !== 1) {
            $userBranch = Auth::user()->branch->branch;
            $locationBranch = Location::where('name', 'LIKE', $userBranch)->first();
            $bookings = Booking::where('location_id', $locationBranch->id)
                                 ->whereDate('created_at', $currentDate)
                                 ->get();

            // Fetch the total bookings per day for the current month
            $bookingsCountPerDay = Booking::where('location_id', $locationBranch->id)
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
                ->orderBy('created_at')
                ->get()
                ->groupBy(function($date) {
                    return Carbon::parse($date->created_at)->format('j M'); // Group by day
                })
                ->map(function($item) {
                    return $item->count(); // Get the count of bookings for each day
            });
        } else {
            $bookings = Booking::whereDate('created_at', $currentDate)->get();

            $bookingsCountPerDay = Booking::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
                ->orderBy('created_at')
                ->get()
                ->groupBy(function($date) {
                    return Carbon::parse($date->created_at)->format('j M'); // Group by day
                })
                ->map(function($item) {
                    return $item->count(); // Get the count of bookings for each day
            });
        }

        $bookingsCountPerDayByBranch = Booking::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
            ->orderBy('created_at')
            ->get()
            ->groupBy(function($booking) {
                return Carbon::parse($booking->created_at)->format('j M');
            })
            ->map(function($bookings) {
                return $bookings->groupBy('location_id')->map(function($branchBookings) {
                    return $branchBookings->count();
                });
            });
        
        // dd($bookingsCountPerDayByBranch);
        return view('admin.admin', ['bookings' => $bookings,
                                    'locations' => $locations,
                                    'stylists' => $stylists,
                                    'services' => $services,
                                    'customers' => $customers,
                                    'bookingsCountPerDay' => $bookingsCountPerDay,
                                    'bookingsCountPerDayByBranch' => $bookingsCountPerDayByBranch,
        ]);
    }

    public function customer() {
        $customers = Customer::orderBy('created_at', 'desc')->get();
        $booking = Booking::all();

        return view('admin.customer', ['customers' => $customers, 'booking' => $booking]);
    }

    public function appointment() {
        $bookings;
        $locations = Location::all();
        $stylists = Stylist::all();
        $services = Service::all();
        $customers = Customer::all();
        // Get the current month and year

        if (Auth::user()->role_id !== 1) {
            $userBranch = Auth::user()->branch->branch;
            $locationBranch = Location::where('name', 'LIKE', $userBranch)->first();
            $bookings = Booking::where('location_id', $locationBranch->id)->get();

        } else {
            $bookings = Booking::all();
        }

        return view('admin.appointment', ['bookings' => $bookings,
                                    'locations' => $locations,
                                    'stylists' => $stylists,
                                    'services' => $services,
                                    'customers' => $customers,
        ]);
    }

    public function location() {
        $location = Location::with('stylists')->get();
        $stylists = Stylist::with('services')->get();
        $services = Service::all();
        $userBranch = Auth::user()->branch->branch;
        $locationBranch = Location::where('name', 'LIKE', $userBranch)->first();
        return view('admin.locations', ['location' => $location,
                                        'stylists' => $stylists,
                                        'services' => $services,
                                        'locationBranch' => $locationBranch]);
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
            if ($request->has('services')) {
                // Get all services
                $services = Service::all();
                
                // Get the branch name from the request
                $branchName = $request->name; // Assuming you have a way to get the branch name
                
                foreach ($services as $service) {
                    // Decode the JSON branch array and ensure it's an array
                    $branchArray = json_decode($service->branch, true) ?: [];
                    
                    // Check if the service is checked in the form submission
                    $isChecked = in_array($service->id, $request->input('services', []));
                    
                    // If the service is checked, add the branch name to the JSON array
                    if ($isChecked && !in_array($branchName, $branchArray)) {
                        $branchArray[] = $branchName;
                    } elseif (!$isChecked) {
                        // If the service is not checked, remove the branch name from the JSON array
                        $branchArray = array_values(array_diff($branchArray, [$branchName]));
                    }
                    
                    // Encode the modified branch array back to JSON maintaining the array format
                    $service->branch = json_encode(array_values($branchArray), JSON_UNESCAPED_UNICODE);
                    $service->save();
                }
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
            if ($request->has('services')) {
                // Get all services
                $services = Service::all();
                
                // Get the branch name from the request
                $branchName = $request->name; // Assuming you have a way to get the branch name
                
                foreach ($services as $service) {
                    // Decode the JSON branch array and ensure it's an array
                    $branchArray = json_decode($service->branch, true) ?: [];
                    
                    // Check if the service is checked in the form submission
                    $isChecked = in_array($service->id, $request->input('services', []));
                    
                    // If the service is checked, add the branch name to the JSON array
                    if ($isChecked && !in_array($branchName, $branchArray)) {
                        $branchArray[] = $branchName;
                    } elseif (!$isChecked) {
                        // If the service is not checked, remove the branch name from the JSON array
                        $branchArray = array_values(array_diff($branchArray, [$branchName]));
                    }
                    
                    // Encode the modified branch array back to JSON maintaining the array format
                    $service->branch = json_encode(array_values($branchArray), JSON_UNESCAPED_UNICODE);
                    $service->save();
                }
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
        $locations = Location::all();
        $stylistSchedule = StylistSchedule::all();
        return view('admin.stylists', ['stylist' => $stylist, 'service' => $service, 'stylistSchedule' => $stylistSchedule, 'locations' => $locations]);
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

            $checkedLocations = $request->input('branch', []);

            $stylist = Stylist::findOrFail($id);
            $stylist->first_name = $request->first_name;
            $stylist->last_name = $request->last_name;
            $stylist->display_name = $request->display_name;
            $stylist->title = $request->title;
            $stylist->bio = $request->bio;
            $stylist->email = $request->email;
            $stylist->image = $fullpath;
            $stylist->branch = json_encode($checkedLocations);
            $stylist->save();
        } else {
            $checkedLocations = $request->input('branch', []);
            $stylist = Stylist::findOrFail($id);
            $stylist->first_name = $request->first_name;
            $stylist->last_name = $request->last_name;
            $stylist->display_name = $request->display_name;
            $stylist->title = $request->title;
            $stylist->bio = $request->bio;
            $stylist->email = $request->email;
            $stylist->branch = json_encode($checkedLocations);
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
        $role = Role::all();
        $branch = Branch::all();
        return view('admin.users', ['users' => $users, 'role' => $role, 'branch' => $branch]);
    }

    public function addUser(Request $request) {
        $user = new User;
        $password = "Hairtric!2345";
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $hashedPassword;
        $user->role_id = $request->role;
        $user->branch_id = $request->branch;
        $user->save();

        if($user) {
            Session::flash('status', 'success');
            Session::flash('message', 'Successfulyy added !');
        }

        return redirect("/dashboard/users");
    }

    public function viewUser($id) {
        $user = User::findOrFail($id);
        $role = Role::all();
        $branch = Branch::all();
        return view('admin.user-view', ['user' => $user, 'role' => $role, 'branch' => $branch]);
    }

    public function editUser(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->branch_id = $request->branch;
        $user->save();

        if ($user) {
            Session::flash('status', 'success');
            Session::flash('message', 'successfully edited!');
        }

        return redirect('/dashboard/view-user/' . $id);
    }

    public function changePasswordUser(Request $request, $id) {
        $user = User::findOrFail($id);
        $currentPassword = $request->currentPassword;

        if (Hash::check($currentPassword, $user->password)) {
            $user->password = $request->password;
            $user->save();
            Session::flash('status', 'success');
            Session::flash('message', 'Successfully changed password');
            return redirect('/dashboard/view-user/'. $id);
        } else {
            Session::flash('status', 'danger');
            Session::flash('message', 'old password not match with current password');
            return redirect('/dashboard/view-user/'. $id);
        }
    }

    public function massUpdateService() {
        $defaultBranch = [1, 2, 3, 4, 5, 6, 7];

        // Mass update existing records with the default branch value
        Stylist::whereNull('branch')->update(['branch' => $defaultBranch]);
    }
}
