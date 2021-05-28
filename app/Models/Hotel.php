<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    /**
     * returns all trip linked to this hotel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * returns all orders for trips for this hotel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function orders()
    {
        return $this->hasManyThrough(Order::class, Trip::class);
    }

    /**
     * returns 7-days weather forecast for hotel's area
     *
     * @return array|mixed|null
     */
    public function weather()
    {
        $weather = Weather::getWeather($this->latitude, $this->longitude);
        return $weather;
    }
}
