<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = file_get_contents(database_path('seeders/data/services.json'));

        $data = json_decode($services, true);
        foreach($data as $service){
            DB::table('services')->insert($service);
        };
    }
}