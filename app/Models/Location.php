<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'full_address', 'image', 'status'];

    public function stylists() {
        return $this->belongsToMany(Stylist::class, 'locations_stylists');
    }

    public function bookings() {
        return $this->hasMany(Booking::class);
    }

}
