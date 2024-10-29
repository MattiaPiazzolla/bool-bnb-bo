<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->text('description', 500)->nullable();
            $table->foreignId('user_id');
            $table->string('address', 255);
            $table->string('city', 50);
            $table->foreignId('adv_id')->default(1);
            $table->string('image', 255)->nullable();
            $table->foreignId('image_id')->nullable();
            $table->decimal('price', 7, 2);
            $table->integer('bedrooms')->nullable();
            $table->foreignId('types_id');
            $table->boolean('is_avilable')->default(true);
            $table->foreignId('rules_id')->nullable();
            $table->foreignId('services_id')->nullable();
            $table->foreignId('reviews_id')->nullable();

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
        Schema::dropIfExists('properties');
    }
};