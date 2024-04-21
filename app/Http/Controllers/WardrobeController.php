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
        ]);

        $user_id = auth()->id();
        $validated['user_id'] = $user_id;
    
        // Create and save the user
        $wardrobe = Clothing::create($validated);

        // Redirect to the home page
        return redirect("/wardrobe");
    }

    public function show($id)
    {
        $wardrobe = Wardrobe::find($id);

        return view('wardrobe.show', compact('wardrobe'));
    }


    public function edit($id)
    {
        $wardrobe = Wardrobe::find($id);

        return view('wardrobe.edit', compact('wardrobe'));
    }

    public function update($id)
    {
        // Validate the user
        $validated = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required'
        ]);

        // Create and save the user
        $wardrobe = Wardrobe::find($id);
        $wardrobe->update($validated);

        // Redirect to the home page
        return redirect("/wardrobe");
    }

    public function destroy($id)
    {
        $wardrobe = Wardrobe::find($id);
        $wardrobe->delete();

        return redirect("/wardrobe");
    }


}
