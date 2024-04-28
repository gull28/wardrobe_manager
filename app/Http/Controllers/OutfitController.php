<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outfit;
use App\Models\Clothing;
use App\Transformers\OutfitTransformer;

class OutfitController extends Controller
{
    public $clothingTypes = [
        'shirt' => 'Shirt',
        'pants' => 'Pants',
        'shoes' => 'Shoes',
        'accessory' => 'Accessory',
        'other' => 'Other',
    ];

    public function index()
    {
        $outfits = Outfit::where('user_id', auth()->id())->with('clothing')->get();
        $transformedOutfits = OutfitTransformer::transform($outfits);

        return view('outfit.index', ['outfits' => $transformedOutfits, 'clothingTypes' => $this->clothingTypes]);
    }

    public function create()
    {
        // get all clothes and sort them by category
        $clothes = Clothing::where('user_id', auth()->id())->get();
        $clothesByCategory = $clothes->groupBy('category');

        return view('outfit.create', [
            'clothingTypes' => $this->clothingTypes,
            'clothesByCategory' => $clothesByCategory,
        ]);
    }

    public function store()
    {
        $validated = request()->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'Shirt' => 'required',
            'Pants' => 'required',
            'Shoes' => 'required',
            'Accessory' => 'required',
            'Other' => 'required',
        ]);

        $user_id = auth()->id();

        $outfit = Outfit::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'user_id' => $user_id,
        ]);

        $clothes = [
            'Shirt' => $validated['Shirt'],
            'Pants' => $validated['Pants'],
            'Shoes' => $validated['Shoes'],
            'Accessory' => $validated['Accessory'],
            'Other' => $validated['Other'],
        ];

        foreach ($clothes as $type => $clothing_id) {
            if ($clothing_id !== 'none') {
                $outfit->clothing()->attach($clothing_id, ['category' => $type]);
            }
        }

        return redirect(route('outfits.index'));
    }

    public function show($id)
    {
        $outfit = Outfit::findOrFail($id);

        return view('outfit.index', ['outfit' => $outfit]);
    }

    public function edit($id)
    {
        $outfit = Outfit::findOrFail($id)->load('clothing');
        $transformedOutfit = OutfitTransformer::transformOne($outfit);

        $clothes = Clothing::where('user_id', auth()->id())->get();
        $clothesByCategory = $clothes->groupBy('category');

        return view('outfit.edit', ['outfit' => $transformedOutfit, 'clothingTypes' => $this->clothingTypes, 'clothesByCategory' => $clothesByCategory]);
    }

    public function update($id)
    {
        $validated = request()->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'Shirt' => 'required',
            'Pants' => 'required',
            'Shoes' => 'required',
            'Accessory' => 'required',
            'Other' => 'required',
        ]);

        $outfit = Outfit::findOrFail($id);

        $outfit->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        $clothes = [
            'Shirt' => $validated['Shirt'],
            'Pants' => $validated['Pants'],
            'Shoes' => $validated['Shoes'],
            'Accessory' => $validated['Accessory'],
            'Other' => $validated['Other'],
        ];

        $outfit->clothing()->detach();

        foreach ($clothes as $type => $clothing_id) {
            if ($clothing_id !== 'none') {
                $outfit->clothing()->attach($clothing_id, ['category' => $type]);
            }
        }

        return redirect(route('outfits.index'));
    }
}
