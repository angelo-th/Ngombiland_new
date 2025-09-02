<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    // return view('property_search'); // Removed invalid statement outside of method

    public function index()
    {
        $properties = Property::where('owner_id', \Auth::id())->get();
        return view('/property_search', compact('properties'));
    }

    public function create() {
        return view('/create_property');
    }

    public function store(Request $request) {
        $request->validate([
            'title'=>'required|string|max:255',
            'owner_id' => 'required|exists:users,id',
            'type'=>'required|string',
            'price'=>'required|numeric',
            'location'=>'required|string',
            'status'=>'required|string'
        ]);

        $property = Property::create([
            'owner_id'=>\Auth::id(),
            'title'=>$request->title,
            'type'=>$request->type,
            'price'=>$request->price,
            'location'=>$request->location,
            'status'=>$request->status
        ]);

        return redirect()->route('properties.index')->with('success','Bien créé avec succès');
    }

    public function edit(Property $property) {
        $this->authorize('update', $property);
        return view('dashboard.edit_property', compact('property'));
    }

    public function update(Request $request, Property $property) {
        $this->authorize('update', $property);

        $request->validate([
            'title'=>'required|string|max:255',
            'owner_id' => 'required|exists:users,id',
            'type'=>'required|string',
            'price'=>'required|numeric',
            'location'=>'required|string',
            'status'=>'required|string'
        ]);

        $property->update($request->all());
        return redirect()->route('properties.index')->with('success','Bien mis à jour');
    }

    public function destroy(Property $property) {
        $this->authorize('delete', $property);
        $property->delete();
        return redirect()->route('properties.index')->with('success','Bien supprimé');
    }
}
