<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Clothing;

class WardrobeController extends Controller
{

    public $clothingTypes = [
        'shirt' => 'Shirt',
        'pants' => 'Pants',
        'shoes' => 'Shoes',
        'accessory' => 'Accessory',
        'other' => 'Other'
    ];

    public $sizes = [
        'xs' => 'XS',
        's' => 'S',
        'm' => 'M',
        'l' => 'L',
        'xl' => 'XL',
        'xxl' => 'XXL'
    ];

    public function index()
    {

        $clothes = Clothing::where('user_id', auth()->id())->get();

        return view('wardrobe.index', [
            'clothes' => $clothes
        ]);
    }

    public function create()
    {
        return view('wardrobe.create', [
            'clothingTypes' => $this->clothingTypes,
            'sizes' => $this->sizes
        ]);
    }

    public function store()
    {
        // Validate the user
        $validated = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'color' => 'required',
            'size' => 'required',
            'category' => 'required',
            'brand' => 'required',
            'wear_count' => 'required',
        ]);

        $user_id = auth()->id();
        $validated['user_id'] = $user_id;
    
        $wardrobe = Clothing::create($validated);

        return redirect(route('wardrobe.index'));
    }

    public function show($id)
    {
        $wardrobe = Wardrobe::find($id);

        return view('wardrobe.show', compact('wardrobe'));
    }


    public function edit($id)
    {
        $item = Clothing::find($id);

        return view('wardrobe.edit', [
            'item' => $item,
            'clothingTypes' => $this->clothingTypes,
            'sizes' => $this->sizes
        ]);
    }

    public function update($id)
    {
        $validated = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'color' => 'required',
            'size' => 'required',
            'category' => 'required',
            'brand' => 'required',
            'wear_count' => 'required',
        ]);

        $wardrobe = Clothing::find($id);
        $wardrobe->update($validated);

        return redirect("/wardrobe");
    }

    public function destroy($id)
    {
        $clothing = Clothing::findOrfail($id);

        // delete all the relationships
        $clothing->outfits()->detach();

        $clothing->delete();

        return redirect(route('wardrobe.index'));
    }

    public function wash($id)
    {
        $clothing = Clothing::find($id);
        $clothing->uses_left = $clothing->wear_count;
        $clothing->save();

        return redirect(route('wardrobe.index'));
    }
}
