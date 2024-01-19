<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stylist extends Model
{
    use HasFactory;

    public function schedule() {
        return $this->hasMany(StylistSchedule::class);
    }

    public function services() {
        return $this->belongsToMany(Service::class, 'stylists_services');
    }

    public function locations() {
        return $this->belongsToMany(Location::class, 'locations_stylists');
    }
}
