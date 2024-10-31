<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        foreach($data as $subscription){
            DB::table('subscriptions')->insert($subscription);
        };
    }
}