<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outfit;

class OutfitController extends Controller
{
    public $clothingTypes = [
        'shirt' => 'Shirt',
        'pants' => 'Pants',
        'shoes' => 'Shoes',
        'accessory' => 'Accessory',
        'other' => 'Other'
    ];

    // WIP
    public function index(){
        $outfits = Outfit::where('user_id', auth()->id())->get();

        return view('outfit.index', ['outfits' => $outfits]);
    }

    public function create(){
        return view('outfit.create', [
            'clothingTypes' => $this->clothingTypes,
        ]);
    }

    public function store(){
        // Validate the user
        $validated = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'clothing_ids' => 'required',
        ]);

        $user_id = auth()->id();
        $validated['user_id'] = $user_id;
        
        // Create and save the user
        $outfit = Outfit::create($validated);
    }

    public function show($id){
        $outfit = Outfit::findOrFail($id);
        // $clothes = $outfit->clothes;

        return view('outfit.index', ['outfit' => $outfit]);
    }

    public function edit($id){
        $outfit = Outfit::findOrFail($id);
        return view('outfit.edit', ['outfit' => $outfit]);
    }
}
