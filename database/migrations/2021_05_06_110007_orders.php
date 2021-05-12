<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->nullable();
            $table->foreignId('user_id');
            $table->boolean('paid')->default(false);
            $table->timestamp('reservation_expires');
            $table->decimal('price', 10, 2);
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
