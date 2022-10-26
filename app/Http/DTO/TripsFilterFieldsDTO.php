<?php

namespace App\Http\DTO;

class TripsFilterFieldsDTO
{
    public int $people;
    public string $meal;
    public int $min_date_in;
    public int $max_date_in;
    public int $min_date_out;
    public int $max_date_out;
    public string $hotel;
    public string $tag;
    public int $discount;
    public int $min_price;
    public int $max_price;
    public string $order;
    public string $direction = 'asc';
    public int $limit;
}
