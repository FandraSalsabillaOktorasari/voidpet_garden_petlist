<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Species;

class SpeciesSeeder extends Seeder
{
    public function run(): void
    {
        $speciesData = [
            ['name' => 'Envy', 'default_element' => 'metal'],
            ['name' => 'Anxious', 'default_element' => 'wood'],
            ['name' => 'Sad', 'default_element' => 'water'],
            ['name' => 'Anger', 'default_element' => 'fire'],
            ['name' => 'Pain', 'default_element' => 'fire'],
            ['name' => 'Spite', 'default_element' => 'metal'],
            ['name' => 'Lonely', 'default_element' => 'water'],
            ['name' => 'Paranoia', 'default_element' => 'metal'],
            ['name' => 'Sonder', 'default_element' => 'water'],
            ['name' => 'Sanctimony', 'default_element' => 'earth'],
            ['name' => 'Abandonment', 'default_element' => 'water'],
            ['name' => 'Jealous', 'default_element' => 'wood'],
            ['name' => 'Gluttony', 'default_element' => 'earth'],
            ['name' => 'Pride', 'default_element' => 'metal'],
            ['name' => 'Lust', 'default_element' => 'metal'],
            ['name' => 'Sloth', 'default_element' => 'earth'],
            ['name' => 'Wrath', 'default_element' => 'fire'],
            ['name' => 'Greed', 'default_element' => 'fire'],
            ['name' => 'Estrangement', 'default_element' => 'water'],
            ['name' => 'Nostalgia', 'default_element' => 'earth'],
            ['name' => 'Judgement', 'default_element' => 'metal'],
            ['name' => 'Salty', 'default_element' => 'earth'],
            ['name' => 'Sadge', 'default_element' => 'water'],
            ['name' => 'Down Bad', 'default_element' => 'wood'],
            ['name' => 'Cringe', 'default_element' => 'wood'],
            ['name' => 'Grumpy', 'default_element' => 'earth'],
            ['name' => 'Curious', 'default_element' => 'wood'],
            ['name' => 'Glee', 'default_element' => 'earth'],
            ['name' => 'Rejection', 'default_element' => 'water'],
            ['name' => 'Desperate', 'default_element' => 'metal'],
            ['name' => 'Defiance', 'default_element' => 'fire'],
            ['name' => 'Merry', 'default_element' => 'wood'],
            ['name' => 'Apathy', 'default_element' => 'earth'],
            ['name' => 'Disdain', 'default_element' => 'metal'],
            ['name' => 'Panic', 'default_element' => 'fire'],
            ['name' => 'Resistance', 'default_element' => 'earth'],
            ['name' => 'Determination', 'default_element' => 'fire'],
            ['name' => 'Wonder', 'default_element' => 'wood'],
            ['name' => 'Mischief', 'default_element' => 'wood'],
            ['name' => 'Persistence', 'default_element' => 'water'],
            ['name' => 'Ambition', 'default_element' => 'water'],
            ['name' => 'Conviction', 'default_element' => 'metal'],
            ['name' => 'Joy', 'default_element' => 'fire'],
            ['name' => 'Wistful', 'default_element' => 'wood'],
            ['name' => 'Scorn', 'default_element' => 'metal'],
            ['name' => 'Diligence', 'default_element' => 'earth'],
            ['name' => 'Patience', 'default_element' => 'wood'],
            ['name' => 'Charity', 'default_element' => 'fire'],
            ['name' => 'Petulance', 'default_element' => 'wood'],
            ['name' => 'Devotion', 'default_element' => 'fire'],
            ['name' => 'Kind', 'default_element' => 'wood'],
            ['name' => 'Rapture', 'default_element' => 'fire'],
            ['name' => 'Chastity', 'default_element' => 'metal'],
            ['name' => 'Temperance', 'default_element' => 'water'],
            ['name' => 'Humble', 'default_element' => 'water'],
        ];

        foreach ($speciesData as $data) {
            Species::firstOrCreate(['name' => $data['name']], ['default_element' => $data['default_element']]);
        }
    }
}
