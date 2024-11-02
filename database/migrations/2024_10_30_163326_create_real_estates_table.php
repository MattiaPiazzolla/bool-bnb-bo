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
        Schema::create('real_estates', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->text('description', 500)->nullable();
            $table->foreignId('user_id');
            $table->string('address', 255);
            $table->string('city', 50);
            $table->decimal('latitude', 8, 6)->nullable();
            $table->decimal('longitude', 8, 6)->nullable();
            // $table->foreignId('subscription_id');
            // $table->foreignId('image_id');
            $table->string('portrait', 255)->nullable();
            $table->decimal('price', 8, 2);
            $table->integer('rooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('beds')->nullable();
            $table->integer('square_meter')->nullable();
            $table->string('structure_types', 50)->default('Appartamento');
            $table->boolean('avilability')->default(true);
            // $table->foreignId('messages_id');
            // $table->foreignId('services_id');
            // $table->foreignId('views_id');
            
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
        Schema::dropIfExists('real_estates');
    }
};