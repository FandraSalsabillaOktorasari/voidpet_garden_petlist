<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// 1. Dapatkan nama dari DB
$dbNames = \App\Models\Species::pluck('name')->map(function($n) { return strtolower(trim($n)); })->toArray();

// 2. Dapatkan nama dari JS Enum
$jsContent = file_get_contents(__DIR__ . '/_app-10048173cdfd9e05.js');
// Cari blok SpeciesId
// Blok dimulai dengan: t[t.Envy = 0] = "Envy"
// dan berlanjut dengan koma. Kita cari substring ini:
preg_match('/t\[t\.Envy\s*=\s*0\].+?(?=\}\s*,)/s', $jsContent, $blockMatch);

$missing = [];
if (!empty($blockMatch[0])) {
    $enumBlock = $blockMatch[0];
    preg_match_all('/t\[t\.([A-Za-z]+)\s*=\s*\d+\]\s*=\s*"([^"]+)"/', $enumBlock, $matches);
    
    $jsSpeciesNames = $matches[2];
    
    foreach ($jsSpeciesNames as $jsName) {
        if (!in_array(strtolower(trim($jsName)), $dbNames)) {
            $missing[] = $jsName;
        }
    }
    
    echo "DB Count: " . count($dbNames) . "\n";
    echo "JS Enum Count: " . count($jsSpeciesNames) . "\n";
    echo "Missing in DB:\n";
    print_r($missing);
} else {
    echo "Block not found";
}
