<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    public function tagAssigns()
    {
        return $this->hasMany(TagAssign::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
