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
        Schema::create('views', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);  
            $table->foreignId('real_estate_id')->constrained();  
            $table->timestamps();

            // Aggiungiamo un vincolo per evitare duplicati su (ip_address, real_estate_id)
            $table->unique(['ip_address', 'real_estate_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('views');
    }
};