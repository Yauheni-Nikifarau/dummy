<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public  function trips()
    {
        return $this->belongsToMany(Trip::class, 'tag_assigns', 'trip_id', 'tag_id');
    }
}
