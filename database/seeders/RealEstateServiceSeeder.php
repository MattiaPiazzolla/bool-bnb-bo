<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; // Per leggere il file JSON

class RealEstateServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Puoi caricare i dati dal file JSON in un array
        $json = File::get(database_path('seeders/data/real_estate_service_data.json'));
        $data = json_decode($json, true);

        // Usa il DB per inserire i dati nella tabella
        DB::table('real_estate_service')->insert($data);
    }
}