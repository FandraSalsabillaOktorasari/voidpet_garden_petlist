<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPet;
use App\Models\Species;
use App\Models\VividForm;

class UserPetController extends Controller
{
    public function index(Request $request)
    {
        // Data untuk dropdown filter
        $speciesList = Species::orderBy('name')->get();
        $vividForms = VividForm::orderBy('name')->get(); // Tambahkan ini

        // Memanggil data pet beserta relasinya, lalu mengaplikasikan filter dan sort
        $pets = UserPet::with(['species', 'vividForm'])
            ->filter([
                'search'     => $request->search,
                'species'    => $request->species,
                'element'    => $request->element,
                'stage'      => $request->stage,
                'vivid_form' => $request->vivid_form,
                'rarity'     => $request->rarity,    // Tambahan filter baru
                'box_type'   => $request->box_type,  // Tambahan filter baru
            ])
            ->sort($request->sort ?? 'recent')
            ->get();

        return view('pets.index', compact('pets', 'speciesList', 'vividForms'));
    }

    public function duplicates()
    {
        // Ambil semua pet beserta relasinya
        $allPets = UserPet::with(['species', 'vividForm'])->get();

        // Kelompokkan pet berdasarkan kombinasi "Species_FormID"
        $grouped = $allPets->groupBy(function($pet) {
            $formId = $pet->vivid_form_id ?? 'no_form';
            return $pet->species_id . '_' . $formId;
        });

        // Filter: Hanya ambil grup yang anggotanya lebih dari 1 (Duplikat)
        $duplicates = $grouped->filter(function($group) {
            return $group->count() > 1;
        })->map(function($group) {
            // Urutkan tiap grup berdasarkan total_bonus_stat dari yang terbesar
            return $group->sortByDesc('total_bonus_stat')->values();
        });

        // Hapus $pets flat list karena kita akan melakukan looping per grup di view
        return view('pets.duplicates', compact('duplicates'));
    }

    public function create()
    {
        $speciesList = Species::orderBy('name')->get();
        // Mengelompokkan vivid form berdasarkan box untuk memudahkan input
        $vividForms = VividForm::orderBy('box_type')->get();

        return view('pets.create', compact('speciesList', 'vividForms'));
    }

    public function store(Request $request)
    {
        // Validasi input dasar
        $request->validate([
            'species_id' => 'required|exists:species,id',
            'vivid_form_id' => 'nullable|exists:vivid_forms,id',
            'stage' => 'required|integer|min:1',
            'level' => 'required|integer|min:1',
            // Stats (bisa ditambahkan validasi max jika ada batasnya di game)
        ]);

        $data = $request->all();
        $data['is_favorite'] = $request->has('is_favorite');

        // Pastikan agar stat yang kosong (dikosongkan user saat mengetik) diset ke 0
        // sehingga terhindar dari error 'cannot be null' di database
        $stats = ['intensity', 'clarity', 'stability', 'hp', 'focus', 'calm', 'speed', 'balance', 'strength'];
        foreach ($stats as $stat) {
            $data[$stat] = $data[$stat] ?? 0;
        }

        // Simpan ke database (Logika Default Name dan Element akan berjalan otomatis dari Model!)
        UserPet::create($data);

        return redirect()->route('pets.index')->with('success', 'New Pet Added');
    }

    public function edit(UserPet $pet)
    {
        $speciesList = Species::orderBy('name')->get();
        // Mengelompokkan vivid form berdasarkan box untuk memudahkan input
        $vividForms = VividForm::orderBy('box_type')->get();

        return view('pets.edit', compact('pet', 'speciesList', 'vividForms'));
    }

    public function update(Request $request, UserPet $pet)
    {
        // Validasi input dasar
        $request->validate([
            'species_id' => 'required|exists:species,id',
            'vivid_form_id' => 'nullable|exists:vivid_forms,id',
            'stage' => 'required|integer|min:1',
            'level' => 'required|integer|min:1',
        ]);

        $data = $request->all();
        $data['is_favorite'] = $request->has('is_favorite');

        // Pastikan agar stat yang kosong (dikosongkan user saat mengetik) diset ke 0
        $stats = ['intensity', 'clarity', 'stability', 'hp', 'focus', 'calm', 'speed', 'balance', 'strength'];
        foreach ($stats as $stat) {
            $data[$stat] = $data[$stat] ?? 0;
        }

        $pet->update($data);

        return redirect()->route('pets.index')->with('success', 'Pet successfully updated!');
    }

    public function destroy(UserPet $pet)
    {
        try {
            $pet->delete();

            // Jika user menghapus dari halaman duplicates, kembalikan ke halaman duplicates
            if (str_contains(url()->previous(), 'duplicates')) {
                return redirect()->route('pets.duplicates')->with('success', 'Pet successfully released to the Void!');
            }

            // Default kembali ke halaman index
            return redirect()->route('pets.index')->with('success', 'Pet successfully released to the Void!');
        } catch (\Exception $e) {
            if (str_contains(url()->previous(), 'duplicates')) {
                return redirect()->route('pets.duplicates')->with('error', $e->getMessage());
            }
            return redirect()->route('pets.index')->with('error', $e->getMessage());
        }
    }
}