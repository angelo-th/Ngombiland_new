<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $favorites = $user->favorites()->with('property')->paginate(12);
        
        return view('favorites.index', compact('favorites'));
    }

    public function store(Property $property)
    {
        $user = auth()->user();
        
        // Vérifier si déjà en favori
        if ($user->favorites()->where('property_id', $property->id)->exists()) {
            return back()->with('error', 'Cette propriété est déjà dans vos favoris');
        }

        $user->favorites()->create([
            'property_id' => $property->id
        ]);

        return back()->with('success', 'Propriété ajoutée aux favoris');
    }

    public function destroy(Property $property)
    {
        $user = auth()->user();
        $user->favorites()->where('property_id', $property->id)->delete();

        return back()->with('success', 'Propriété retirée des favoris');
    }
}