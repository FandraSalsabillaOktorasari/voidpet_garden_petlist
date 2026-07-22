<?php

namespace App\Http\Controllers;

use App\Models\Species;
use App\Models\VividForm;
use App\Models\UserPet;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function index(Request $request)
    {
        $speciesList = Species::orderBy('name')->get();
        
        $selectedBoxType = $request->input('box_type');
        
        $vividFormsQuery = VividForm::query();
        
        if ($selectedBoxType && $selectedBoxType !== 'regular') {
            $vividFormsQuery->where('box_type', $selectedBoxType);
        }
        
        $vividForms = $selectedBoxType === 'regular' ? collect() : $vividFormsQuery->get();
        $groupedVividForms = $vividForms->groupBy('box_type');
        
        $userPets = UserPet::select('species_id', 'vivid_form_id')->get();
        
        $ownedMap = [];
        foreach ($userPets as $pet) {
            $speciesId = $pet->species_id;
            $formId = $pet->vivid_form_id ?? 'regular';
            $ownedMap[$speciesId][$formId] = true;
        }
        
        $boxTypes = VividForm::select('box_type')->distinct()->pluck('box_type');

        return view('pets.checklist', compact('speciesList', 'groupedVividForms', 'ownedMap', 'boxTypes', 'selectedBoxType'));
    }
}
