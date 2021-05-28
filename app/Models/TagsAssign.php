<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagsAssign extends Model
{
    use HasFactory;

    /**
     * Returns information about it's trips
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trips() {
        return $this->belongsTo(Trip::class);
    }

    /**
     * returns information about it's tag
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tag() {
        return $this->belongsTo(Tag::class);
    }
}
