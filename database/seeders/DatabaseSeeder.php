<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $dtdef = [
            ['name' => 'Admin', 'email' => 'admin@app.com'],
            ['name' => 'Tommy Irawan Patra', 'email' => 'tommy@app.com'],
            ['name' => 'Amalia', 'email' => 'amalia@app.com'],
            ['name' => 'Aleesya', 'email' => 'aleesya@app.com'],
            ['name' => 'Al Fath', 'email' => 'alfath@app.com'],
            ['name' => 'Arumi', 'email' => 'arumi@app.com'],
        ];

        foreach ($dtdef as $dt) {
            User::create([
                'name' => $dt['name'],
                'email' => $dt['email'],
                'password' => Hash::make('00000000'),
            ]);
        }
    }
}
