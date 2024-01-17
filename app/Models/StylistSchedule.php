<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StylistSchedule extends Model
{
    use HasFactory;

    public function stylist() {
        return $this->belongsTo(Stylist::class);
    }
}
