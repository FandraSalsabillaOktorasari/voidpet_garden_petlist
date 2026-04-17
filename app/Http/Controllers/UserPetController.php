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

        // Simpan ke database (Logika Default Name dan Element akan berjalan otomatis dari Model!)
        UserPet::create($data);

        return redirect()->route('pets.index')->with('success', 'New Pet Added');
    }

    public function destroy(UserPet $pet)
    {
        try {
            $pet->delete();
            return redirect()->route('pets.index')->with('success', 'Pet successfully released to the Void!');
        } catch (\Exception $e) {
            return redirect()->route('pets.index')->with('error', $e->getMessage());
        }
    }
}