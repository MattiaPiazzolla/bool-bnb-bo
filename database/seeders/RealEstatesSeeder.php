<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RealEstatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $apartments = file_get_contents(database_path('seeders/data/apartments.json'));

        $data = json_decode($apartments, true);
        foreach($data as $apartment){
            DB::table('real_estates')->insert($apartment);
        };
    }
}