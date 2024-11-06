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
        Schema::create('real_estate_subscription', function (Blueprint $table) {
            $table->id();
            
            // Definisci la chiave esterna per real_estate_id
            $table->foreignId('real_estate_id')
                  ->constrained('real_estates')  // Definisci la tabella di riferimento
                  ->onDelete('cascade');         // Cancella automaticamente i collegamenti se un immobile è eliminato
            
            // Definisci la chiave esterna per subscription_id
            $table->foreignId('subscription_id')
                  ->constrained('subscriptions') // Definisci la tabella di riferimento
                  ->onDelete('cascade');         // Cancella automaticamente i collegamenti se una sottoscrizione è eliminata

            // Aggiungi il campo end_subscription
            $table->timestamp('end_subscription')->nullable();
            
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
        Schema::dropIfExists('real_estate_subscription');
    }
};