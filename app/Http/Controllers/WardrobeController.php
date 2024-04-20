<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WardrobeController extends Controller
{
    public function index()
    {
        return view('wardrobe.index');
    }

    public function create()
    {
        return view('wardrobe.create');
    }

    public function store()
    {
        // Validate the user
        $validated = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required'
        ]);

        // Create and save the user
        $wardrobe = Wardrobe::create($validated);

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
