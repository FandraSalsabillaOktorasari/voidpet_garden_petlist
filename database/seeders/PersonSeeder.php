<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Person;

class PersonSeeder extends Seeder
{
    public function run(): void
    {
        $people = ['Tilde', 'Char', 'Hyphen', 'Alt', 'Volo', 'Pecunia', 'Promise', 'Pandora'];
        
        foreach ($people as $name) {
            Person::firstOrCreate(['name' => $name]);
        }
    }
}
