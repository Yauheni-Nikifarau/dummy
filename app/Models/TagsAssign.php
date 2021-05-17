<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagsAssign extends Model
{
    use HasFactory;

    public function trips() {
        return $this->belongsTo(Trip::class);
    }

    public function tag() {
        return $this->belongsTo(Tag::class);
    }
}
