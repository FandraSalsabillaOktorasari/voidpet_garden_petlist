<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VividForm;

class VividFormSeeder extends Seeder
{
    public function run()
    {
        $vividForms = [
            // --- VOID BOX ---
            ['name' => 'Phantom', 'box_type' => 'void', 'rarity' => 'rare'],
            ['name' => 'Ephemeral', 'box_type' => 'void', 'rarity' => 'rare'],
            ['name' => 'Celestial', 'box_type' => 'void', 'rarity' => 'rare'],
            ['name' => 'Cataclysmic', 'box_type' => 'void', 'rarity' => 'rare'],
            ['name' => 'Jaded', 'box_type' => 'void', 'rarity' => 'fabled'],
            ['name' => 'Ethereal', 'box_type' => 'void', 'rarity' => 'fabled'],
            ['name' => 'Illusive', 'box_type' => 'void', 'rarity' => 'fabled'],
            ['name' => 'Cryptic', 'box_type' => 'void', 'rarity' => 'fabled'],
            ['name' => 'Arcane', 'box_type' => 'void', 'rarity' => 'mythical'],
            ['name' => 'Resolute', 'box_type' => 'void', 'rarity' => 'mythical'],
            ['name' => 'Fathomless', 'box_type' => 'void', 'rarity' => 'mythical'],
            ['name' => 'Elemental', 'box_type' => 'void', 'rarity' => 'mythical'],
            ['name' => 'Corrosive', 'box_type' => 'void', 'rarity' => 'absurd'],
            ['name' => 'Unidentified', 'box_type' => 'void', 'rarity' => 'absurd'],
            ['name' => 'Intoxicating', 'box_type' => 'void', 'rarity' => 'absurd'],
            ['name' => 'Tartarean', 'box_type' => 'void', 'rarity' => 'absurd'],

            // --- WOOD BOX ---
            ['name' => 'Pithy', 'box_type' => 'wood', 'rarity' => 'rare'],
            ['name' => 'Protean', 'box_type' => 'wood', 'rarity' => 'rare'],
            ['name' => 'Maverick', 'box_type' => 'wood', 'rarity' => 'rare'],
            ['name' => 'Saccharine', 'box_type' => 'wood', 'rarity' => 'rare'],
            ['name' => 'Puerile', 'box_type' => 'wood', 'rarity' => 'fabled'],
            ['name' => 'Quixotic', 'box_type' => 'wood', 'rarity' => 'fabled'],
            ['name' => 'Baroque', 'box_type' => 'wood', 'rarity' => 'fabled'],
            ['name' => 'Verdant', 'box_type' => 'wood', 'rarity' => 'fabled'],
            ['name' => 'Sylvan', 'box_type' => 'wood', 'rarity' => 'mythical'],
            ['name' => 'Euphoric', 'box_type' => 'wood', 'rarity' => 'mythical'],
            ['name' => 'Sordid', 'box_type' => 'wood', 'rarity' => 'mythical'],
            ['name' => 'Succulent', 'box_type' => 'wood', 'rarity' => 'mythical'],
            ['name' => 'Malefic', 'box_type' => 'wood', 'rarity' => 'absurd'],
            ['name' => 'Parasitic', 'box_type' => 'wood', 'rarity' => 'absurd'],
            ['name' => 'Pernicious', 'box_type' => 'wood', 'rarity' => 'absurd'],
            ['name' => 'Elysian', 'box_type' => 'wood', 'rarity' => 'absurd'],

            // --- FIRE BOX ---
            ['name' => 'Subdued', 'box_type' => 'fire', 'rarity' => 'rare'],
            ['name' => 'Ardent', 'box_type' => 'fire', 'rarity' => 'rare'],
            ['name' => 'Flagrant', 'box_type' => 'fire', 'rarity' => 'rare'],
            ['name' => 'Incendiary', 'box_type' => 'fire', 'rarity' => 'rare'],
            ['name' => 'Sallow', 'box_type' => 'fire', 'rarity' => 'fabled'],
            ['name' => 'Capricious', 'box_type' => 'fire', 'rarity' => 'fabled'],
            ['name' => 'Paranormal', 'box_type' => 'fire', 'rarity' => 'fabled'],
            ['name' => 'Patrician', 'box_type' => 'fire', 'rarity' => 'fabled'],
            ['name' => 'Insurgent', 'box_type' => 'fire', 'rarity' => 'mythical'],
            ['name' => 'Residual', 'box_type' => 'fire', 'rarity' => 'mythical'],
            ['name' => 'Desolate', 'box_type' => 'fire', 'rarity' => 'mythical'],
            ['name' => 'Carnivorous', 'box_type' => 'fire', 'rarity' => 'mythical'],
            ['name' => 'Galvanic', 'box_type' => 'fire', 'rarity' => 'absurd'],
            ['name' => 'Voltaic', 'box_type' => 'fire', 'rarity' => 'absurd'],
            ['name' => 'Renegade', 'box_type' => 'fire', 'rarity' => 'absurd'],
            ['name' => 'Infernal', 'box_type' => 'fire', 'rarity' => 'absurd'],

            // --- EARTH BOX ---
            ['name' => 'Allegiant', 'box_type' => 'earth', 'rarity' => 'rare'],
            ['name' => 'Adamant', 'box_type' => 'earth', 'rarity' => 'rare'],
            ['name' => 'Resonant', 'box_type' => 'earth', 'rarity' => 'rare'],
            ['name' => 'Sacral', 'box_type' => 'earth', 'rarity' => 'rare'],
            ['name' => 'Veracious', 'box_type' => 'earth', 'rarity' => 'fabled'],
            ['name' => 'Diaphanous', 'box_type' => 'earth', 'rarity' => 'fabled'],
            ['name' => 'Fictile', 'box_type' => 'earth', 'rarity' => 'fabled'],
            ['name' => 'Tectonic', 'box_type' => 'earth', 'rarity' => 'fabled'],
            ['name' => 'Apocryphal', 'box_type' => 'earth', 'rarity' => 'mythical'],
            ['name' => 'Primeval', 'box_type' => 'earth', 'rarity' => 'mythical'],
            ['name' => 'Sepulchral', 'box_type' => 'earth', 'rarity' => 'mythical'],
            ['name' => 'Exalted', 'box_type' => 'earth', 'rarity' => 'mythical'],
            ['name' => 'Pestilent', 'box_type' => 'earth', 'rarity' => 'absurd'],
            ['name' => 'Leviathan', 'box_type' => 'earth', 'rarity' => 'absurd'],
            ['name' => 'Blasphemous', 'box_type' => 'earth', 'rarity' => 'absurd'],
            ['name' => 'Antediluvian', 'box_type' => 'earth', 'rarity' => 'absurd'],

            // --- WATER BOX ---
            ['name' => 'Halcyon', 'box_type' => 'water', 'rarity' => 'rare'],
            ['name' => 'Thalassic', 'box_type' => 'water', 'rarity' => 'rare'],
            ['name' => 'Peripheral', 'box_type' => 'water', 'rarity' => 'rare'],
            ['name' => 'Sanguine', 'box_type' => 'water', 'rarity' => 'rare'],
            ['name' => 'Limpid', 'box_type' => 'water', 'rarity' => 'fabled'],
            ['name' => 'Whimsical', 'box_type' => 'water', 'rarity' => 'fabled'],
            ['name' => 'Fluid', 'box_type' => 'water', 'rarity' => 'fabled'],
            ['name' => 'Insular', 'box_type' => 'water', 'rarity' => 'fabled'],
            ['name' => 'Pelagic', 'box_type' => 'water', 'rarity' => 'mythical'],
            ['name' => 'Sinuous', 'box_type' => 'water', 'rarity' => 'mythical'],
            ['name' => 'Abyssal', 'box_type' => 'water', 'rarity' => 'mythical'],
            ['name' => 'Hypnotic', 'box_type' => 'water', 'rarity' => 'mythical'],
            ['name' => 'Alkaline', 'box_type' => 'water', 'rarity' => 'absurd'],
            ['name' => 'Liminal', 'box_type' => 'water', 'rarity' => 'absurd'],
            ['name' => 'Undulant', 'box_type' => 'water', 'rarity' => 'absurd'],
            ['name' => 'Stygian', 'box_type' => 'water', 'rarity' => 'absurd'],

            // --- METAL BOX ---
            ['name' => 'Laconic', 'box_type' => 'metal', 'rarity' => 'rare'],
            ['name' => 'Trenchant', 'box_type' => 'metal', 'rarity' => 'rare'],
            ['name' => 'Imperious', 'box_type' => 'metal', 'rarity' => 'rare'],
            ['name' => 'Austere', 'box_type' => 'metal', 'rarity' => 'rare'],
            ['name' => 'Didactic', 'box_type' => 'metal', 'rarity' => 'fabled'],
            ['name' => 'Adroit', 'box_type' => 'metal', 'rarity' => 'fabled'],
            ['name' => 'Synthetic', 'box_type' => 'metal', 'rarity' => 'fabled'],
            ['name' => 'Abstruse', 'box_type' => 'metal', 'rarity' => 'fabled'],
            ['name' => 'Aureate', 'box_type' => 'metal', 'rarity' => 'mythical'],
            ['name' => 'Stolid', 'box_type' => 'metal', 'rarity' => 'mythical'],
            ['name' => 'Axiomatic', 'box_type' => 'metal', 'rarity' => 'mythical'],
            ['name' => 'Spartan', 'box_type' => 'metal', 'rarity' => 'mythical'],
            ['name' => 'Derivative', 'box_type' => 'metal', 'rarity' => 'absurd'],
            ['name' => 'Absolute', 'box_type' => 'metal', 'rarity' => 'absurd'],
            ['name' => 'Radical', 'box_type' => 'metal', 'rarity' => 'absurd'],
            ['name' => 'Cartesian', 'box_type' => 'metal', 'rarity' => 'absurd'],
        ];

        foreach ($vividForms as $form) {
            VividForm::updateOrCreate(['name' => $form['name']], $form);
        }
    }
}