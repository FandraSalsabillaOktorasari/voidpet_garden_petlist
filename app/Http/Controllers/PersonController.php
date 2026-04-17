<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Food;

class PersonController extends Controller
{
    public function index()
    {
        $people = Person::with('foods')->get();
        $foods = Food::orderBy('name')->get();
        
        return view('people.index', compact('people', 'foods'));
    }

    public function storeFood(Request $request, Person $person)
    {
        $request->validate([
            'food_name' => 'required|string|max:255',
            'gift_value' => 'required|integer',
            'throw_value' => 'required|integer',
        ]);

        // Find or create the food by name
        // Karena TomSelect bisa assign string custom baru, ini akan auto save ke tabel Food
        $food = Food::firstOrCreate(['name' => $request->food_name]);

        // Attach atau update pivot
        $exists = $person->foods()->where('food_id', $food->id)->exists();
        if ($exists) {
            $person->foods()->updateExistingPivot($food->id, [
                'gift_value' => $request->gift_value,
                'throw_value' => $request->throw_value,
            ]);
        } else {
            $person->foods()->attach($food->id, [
                'gift_value' => $request->gift_value,
                'throw_value' => $request->throw_value,
            ]);
        }

        return redirect()->route('people.index')->with('success', "Food record added for {$person->name}!");
    }

    public function destroyFood(Person $person, Food $food)
    {
        $person->foods()->detach($food->id);
        return redirect()->route('people.index')->with('success', "Food tracking removed for {$person->name}.");
    }

    public function updateGlobalFood(Request $request, Food $food)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:foods,name,' . $food->id
        ]);

        $food->update(['name' => $request->name]);
        return redirect()->route('people.index')->with('success', 'Food name updated globally.');
    }

    public function destroyGlobalFood(Food $food)
    {
        try {
            $food->delete();
            return redirect()->route('people.index')->with('success', 'Food deleted globally from the list and all character tracking.');
        } catch (\Exception $e) {
            return redirect()->route('people.index')->with('error', 'Failed to delete food.');
        }
    }
}
