<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function orders()
    {
        return $this->hasManyThrough(Order::class, Trip::class);
    }
}
