<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plant;
use App\Models\VividForm;

class PlantController extends Controller
{
    public function index()
    {
        $plants = Plant::with('vividForms')->orderBy('name')->get();

        // Let's get all vivid forms ordered nicely. Maybe group them by Box Type for easier display?
        // But for a simple checklist, a straight list ordered by name or box type is good.
        $allVividForms = VividForm::orderBy('box_type')->orderBy('name')->get();

        return view('plants.index', compact('plants', 'allVividForms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:plants,name',
        ]);

        Plant::create(['name' => $request->name]);

        return redirect()->route('plants.index')->with('success', 'Plant added successfully!');
    }

    public function updateVividForms(Request $request, Plant $plant)
    {
        // $request->vivid_forms will be an array of IDs that are checked.
        // If nothing is checked, it might be null/empty.
        $vividFormIds = $request->input('vivid_forms', []);

        // Sync is perfect for checklists. It will attach the new ones and detach the ones not in the array.
        $plant->vividForms()->sync($vividFormIds);

        return redirect()->route('plants.index')->with('success', "Vivid Forms updated for {$plant->name}!");
    }

    public function destroy(Plant $plant)
    {
        $plant->delete();
        return redirect()->route('plants.index')->with('success', 'Plant deleted successfully!');
    }
}
