<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outfit;
use App\Models\Clothing;

class OutfitController extends Controller
{
    public $clothingTypes = [
        'shirt' => 'Shirt',
        'pants' => 'Pants',
        'shoes' => 'Shoes',
        'accessory' => 'Accessory',
        'other' => 'Other',
    ];

    // WIP
    public function index()
    {
        $outfits = Outfit::where('user_id', auth()->id())->get();

        return view('outfit.index', ['outfits' => $outfits]);
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
            'name' => 'required',
            'description' => 'required',
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
        // $clothes = $outfit->clothes;

        return view('outfit.index', ['outfit' => $outfit]);
    }

    public function edit($id)
    {
        $outfit = Outfit::findOrFail($id);
        return view('outfit.edit', ['outfit' => $outfit]);
    }
}