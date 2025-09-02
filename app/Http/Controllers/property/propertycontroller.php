// app/Http/Controllers/PropertyController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class PropertyController extends Controller
{
    // List all properties
    public function index()
    {
        $properties = Property::with('owner')->get();
        return response()->json($properties);
    }

    // Create a new property
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255'
        ]);

        $property = Property::create($request->all());
        return response()->json(['message' => 'Property created successfully', 'property' => $property], 201);
    }

    // Update property
    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric|min:0',
            'location' => 'string|max:255',
            'status' => 'in:pending,approved,rejected'
        ]);

        $property->update($request->all());
        return response()->json(['message' => 'Property updated successfully', 'property' => $property]);
    }

    // Delete property
    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();
        return response()->json(['message' => 'Property deleted successfully']);
    }

    // Moderate property (approve/reject)
    public function moderate(Request $request, $id)
    {
        $property = Property::findOrFail($id);
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $property->status = $request->status;
        $property->save();

        return response()->json(['message' => "Property has been {$property->status}"]);
    }
}
