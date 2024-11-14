<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ViewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Carica i dati JSON dal file
        $views = file_get_contents(database_path('seeders/data/views.json'));

        // Decodifica i dati JSON in un array associativo
        $data = json_decode($views, true);

        // Inserisci i dati nella tabella 'views'
        foreach ($data as $view) {
            DB::table('views')->insert($view);
        }
    }
}