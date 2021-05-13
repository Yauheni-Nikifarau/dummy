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
        return $this->belongsTo(Discount::class)->withDefault([
            'value' => 0,
            'name' => null
        ]);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function tagsAssigns()
    {
        return $this->hasMany(TagsAssign::class);
    }
}
