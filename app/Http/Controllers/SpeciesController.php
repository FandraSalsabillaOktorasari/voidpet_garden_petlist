<?php

namespace App\Http\Controllers;

use App\Models\Species;
use Illuminate\Support\Facades\Http;

class SpeciesController extends Controller
{
    /**
     * Ambil daftar species terbaru beserta element dari file JS voidpet.com/o/dex
     * dan tambahkan species baru yang belum ada di database.
     */
    public function sync()
    {
        try {
            $response = Http::timeout(15)
                ->withHeaders(['User-Agent' => 'Mozilla/5.0 (VoidpetGardenTracker)'])
                ->get('https://voidpet.com/o/dex');

            if (! $response->successful()) {
                return back()->with('error', 'Gagal mengambil data dari voidpet.com (status: ' . $response->status() . ').');
            }

            // Cari Next.js JS bundles
            preg_match_all('/src="(\/_next\/static\/chunks\/pages\/_app-[^"]+\.js)"/', $response->body(), $appJsMatches);
            preg_match_all('/src="(\/_next\/static\/chunks\/[0-9]+-[^"]+\.js)"/', $response->body(), $chunkJsMatches);
            
            $jsFiles = array_merge($appJsMatches[1] ?? [], $chunkJsMatches[1] ?? []);
            
            if (empty($jsFiles)) {
                return back()->with('error', 'Gagal menemukan JS bundle dari voidpet.com. Struktur website mungkin berubah.');
            }

            // Mapping PrimaryElement ID game ke string element kita
            $elementMap = [
                '0' => 'water',
                '1' => 'metal',
                '2' => 'earth',
                '3' => 'fire',
                '4' => 'wood',
                '5' => 'void'
            ];

            $speciesData = [];

            // 1. Ekstrak data lengkap (nama + element) dari object dictionary JS
            // Pattern: {species:"Envy",primaryElement:1}
            // Telusuri file JS bundle untuk mencari mapping pet
            foreach ($jsFiles as $jsFile) {
                $jsResponse = Http::timeout(15)
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0 (VoidpetGardenTracker)'])
                    ->get('https://voidpet.com' . $jsFile);
                
                $jsBody = $jsResponse->body();
                
                // Cari dari object dictionary (mendukung primaryElement berupa angka ATAU enum seperti C.PetElement.Earth)
                if (preg_match_all('/species:\s*"([^"]+)",\s*primaryElement:\s*(?:(\d+)|[A-Za-z]+\.PetElement\.([A-Za-z]+))/i', $jsBody, $matches, PREG_SET_ORDER)) {
                    foreach ($matches as $match) {
                        $name = trim($match[1]);
                        
                        // Jika group 2 ada nilainya (artinya format angka, misal: 4)
                        if (!empty($match[2])) {
                            $elementId = trim($match[2]);
                            $elementString = $elementMap[$elementId] ?? 'unknown';
                        } 
                        // Jika group 3 ada nilainya (artinya format Enum, misal: C.PetElement.Earth)
                        elseif (!empty($match[3])) {
                            $elementString = strtolower(trim($match[3]));
                        } else {
                            $elementString = 'unknown';
                        }
                        
                        $speciesData[$name] = $elementString;
                    }
                }

                // 2. Ekstrak daftar NAMA lengkap dari blok Enum TypeScript gamenya (baris 3121 dsb)
                // Kita gunakan regex yang lebih fleksibel untuk menangkap blok enum tersebut
                // Blok dimulai dengan: t[t.Envy = 0] = "Envy" dan berakhir sebelum fungsi tertutup
                if (preg_match('/(t\[t\.Envy\s*=\s*0\]\s*=\s*"Envy"[\s\S]+?\}).*?t\s*\|\|/i', $jsBody, $enumBlockMatch)) {
                    $enumBlock = $enumBlockMatch[1];
                    // Ambil hanya nama-nama yang ada di dalam blok enum SpeciesId tersebut
                    if (preg_match_all('/\[[A-Za-z]\.[A-Za-z]+\s*=\s*\d+\]\s*=\s*"([^"]+)"/', $enumBlock, $enumMatches)) {
                        foreach ($enumMatches[1] as $enumName) {
                            $enumName = trim($enumName);
                            $formattedName = preg_replace('/(?<!^)([A-Z])/', ' $1', $enumName); // "DownBad" -> "Down Bad"
                            
                            if ($formattedName !== '' && !isset($speciesData[$formattedName]) && !isset($speciesData[$enumName])) {
                                $speciesData[$formattedName] = 'unknown';
                            }
                        }
                    }
                }
            }

            // Jika entah kenapa data gagal didapat dari JS,
            // fallback ke HTML scrapping (menjaga kode asli kamu tetap berjalan)
            if (empty($speciesData)) {
                preg_match_all('/#(\d+):\s*([A-Z][A-Za-z\' ]*)/', $response->body(), $nameMatches, PREG_SET_ORDER);
                foreach ($nameMatches as $match) {
                    $name = trim($match[2]);
                    if ($name !== '' && !isset($speciesData[$name])) {
                        $speciesData[$name] = 'unknown';
                    }
                }
            }

            if (empty($speciesData)) {
                return back()->with('error', 'Tidak menemukan data species di voidpet.com. Mungkin struktur datanya berubah.');
            }

            // Proses Syncing ke Database
            $existingNames = Species::pluck('name')
                ->map(fn ($name) => strtolower(trim($name)))
                ->all();

            $newSpecies = [];

            foreach ($speciesData as $name => $element) {
                if (in_array(strtolower($name), $existingNames, true)) {
                    continue;
                }

                Species::create([
                    'name' => $name,
                    'default_element' => $element,
                ]);

                $existingNames[] = strtolower($name);
                $newSpecies[] = $name . ' (' . ucfirst($element) . ')';
            }

            if (empty($newSpecies)) {
                return back()->with('success', 'Dicek! Tidak ada species baru — data kamu sudah up to date.');
            }

            return back()->with(
                'success',
                'Berhasil! Menambahkan ' . count($newSpecies) . ' species baru beserta elemen aslinya: ' . implode(', ', $newSpecies) . '.'
            );

        } catch (\Exception $e) {
            return back()->with('error', 'Sync error: ' . $e->getMessage());
        }
    }
}


