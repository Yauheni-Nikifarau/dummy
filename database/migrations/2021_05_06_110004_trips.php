<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Trips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->decimal('price', 10,2);
            $table->timestamp('date_in')->nullable();
            $table->timestamp('date_out')->nullable();
            $table->integer('quantity_of_people');
            $table->foreignId('hotel_id')->unsigned()->nullable();
            $table->char('meal_option', 2);
            $table->boolean('reservation')->default(false);
            $table->foreignId('discount_id')->unsigned()->nullable();
            $table->string('image')->nullable();
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('set null');
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('set null');
            $table->timestamps();
            $table->index('reservation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
