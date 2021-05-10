<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Trip::class, 'tags_assigns', 'tag_id', 'trip_id');
    }
}
