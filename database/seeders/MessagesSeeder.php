<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Carica i dati dal file JSON
        $messages = file_get_contents(database_path('seeders/data/messages.json'));

        // Decodifica il contenuto JSON in un array associativo
        $data = json_decode($messages, true);

        // Inserisci i dati nella tabella 'messages'
        foreach ($data as $message) {
            DB::table('messages')->insert($message);
        }
    }
}