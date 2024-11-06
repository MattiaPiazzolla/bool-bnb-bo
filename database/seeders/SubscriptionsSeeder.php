<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subscriptions = file_get_contents(database_path('seeders/data/subscriptions.json'));

        $data = json_decode($subscriptions, true);
        
        if ($data === null) {
            Log::error('Errore nella decodifica del file JSON');
            return;
        }

        foreach ($data as $subscription) {
            try {
                DB::table('subscriptions')->insert($subscription);
            } catch (\Exception $e) {
                Log::error('Errore nell\'inserimento della sottoscrizione: ' . $e->getMessage());
            }
        }
    }
}