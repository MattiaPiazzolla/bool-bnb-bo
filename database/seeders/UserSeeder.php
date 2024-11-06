<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Carica i dati dal file JSON
        $data = json_decode(file_get_contents(database_path('seeders/data/users.json')), true);

        foreach ($data as $user) {
            // Hash della password in chiaro
            $hashedPassword = Hash::make($user['password']);
            
            // Inserisci i dati nel database
            DB::table('users')->insert([
                'name' => $user['name'],
                'surname' => $user['surname'],
                'date_of_birth' => $user['date_of_birth'],
                'image' => $user['image'],
                'email' => $user['email'],
                'password' => $hashedPassword,  
                'created_at' => $user['created_at'],
                'updated_at' => $user['updated_at'],
            ]);
        }
    }
}