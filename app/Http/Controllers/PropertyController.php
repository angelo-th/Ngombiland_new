<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{


    public function index()
    {
        $properties = Property::with('owner')->latest()->paginate(12);
        return view('properties.index', compact('properties'));
    }

    public function create() {
        return view('properties.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title'=>'required|string|max:255',
            'description'=>'required|string',
            'type'=>'required|string',
            'price'=>'required|numeric|min:0',
            'location'=>'required|string',
            'latitude'=>'nullable|numeric',
            'longitude'=>'nullable|numeric',
            'images'=>'nullable|array',
            'images.*'=>'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $property = Property::create([
            'user_id'=>auth()->id(),
            'title'=>$request->title,
            'description'=>$request->description,
            'type'=>$request->type,
            'price'=>$request->price,
            'location'=>$request->location,
            'latitude'=>$request->latitude,
            'longitude'=>$request->longitude,
            'status'=>'pending'
        ]);

        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');
                $images[] = $path;
            }
            $property->update(['images' => $images]);
        }

        return redirect('/properties')->with('success','Bien créé avec succès');
    }

    public function show(Property $property) {
        return view('properties.show', compact('property'));
    }

    public function edit(Property $property) {
        $this->authorize('update', $property);
        return view('properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property) {
        $this->authorize('update', $property);

        $request->validate([
            'title'=>'required|string|max:255',
            'description'=>'required|string',
            'type'=>'required|string',
            'price'=>'required|numeric|min:0',
            'location'=>'required|string',
            'latitude'=>'nullable|numeric',
            'longitude'=>'nullable|numeric'
        ]);

        $property->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'type'=>$request->type,
            'price'=>$request->price,
            'location'=>$request->location,
            'latitude'=>$request->latitude,
            'longitude'=>$request->longitude
        ]);
        
        return redirect('/properties')->with('success','Bien mis à jour');
    }

    public function destroy(Property $property) {
        $this->authorize('delete', $property);
        $property->delete();
        return redirect('/properties')->with('success','Bien supprimé');
    }
}
