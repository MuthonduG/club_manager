<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClubController extends Controller
{
    // Get all clubs
    public function index()
    {
        return Club::all();
    }

    // Create a new club
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:clubs,name',
            'description' => 'nullable|string',
            'advisor_name' => 'nullable|string',
        ]);

        $club = Club::create($data);

        return response()->json($club, 201);
    }

    // Show a single club
    public function show($id)
    {
        $club = Club::findOrFail($id);
        return response()->json($club);
    }

    // Update an existing club
    public function update(Request $request, $id)
    {
        $club = Club::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string|unique:clubs,name,' . $id,
            'description' => 'nullable|string',
            'advisor_name' => 'nullable|string',
        ]);

        $club->update($data);

        return response()->json($club);
    }

    // Delete a club
    public function destroy($id)
    {
        $club = Club::findOrFail($id);
        $club->delete();

        return response()->json(['message' => 'Club deleted successfully']);
    }

    // Authenticated user joins the club
    public function join($id)
    {
        $club = Club::findOrFail($id);
        $user = Auth::user();

        if ($club->members()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'You already joined this club.'], 409);
        }

        $club->members()->attach($user->id);

        return response()->json(['message' => 'Successfully joined the club.']);
    }

    // List members of a club
    public function members($id)
    {
        $club = Club::with('members')->findOrFail($id);
        return response()->json($club->members);
    }
}
