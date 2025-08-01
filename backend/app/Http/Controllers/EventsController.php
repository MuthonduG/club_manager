<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Events::withCount('attendees')->get(); // Includes RSVP count
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
            'location' => 'required|string|max:255',
            'payment_method' => 'required|string|max:255',
        ]);

        $event = Events::create($request->all());

        return response()->json($event, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Events $event)
    {
        $event->loadCount('attendees'); // Add RSVP count
        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Events $event)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'body' => 'sometimes|required',
            'location' => 'sometimes|required|string|max:255',
            'payment_method' => 'sometimes|required|string|max:255',
        ]);

        $event->update($request->all());

        return response()->json($event, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Events $event)
    {
        $event->delete();

        return response()->json(null, 204);
    }

    /**
     * RSVP the authenticated user to an event.
     */
    public function rsvp(Request $request, $id)
    {
        $event = Events::findOrFail($id);

        // Attach the user only if they haven't already RSVP'd
        $event->attendees()->syncWithoutDetaching([Auth::id()]);

        return response()->json([
            'message' => 'RSVP successful',
            'attendee_count' => $event->attendees()->count(),
        ], 200);
    }

    /**
     * Cancel RSVP for an event.
     */
    public function cancelRsvp(Request $request, $id)
    {
        $event = Events::findOrFail($id);

        $event->attendees()->detach(Auth::id());

        return response()->json([
            'message' => 'RSVP cancelled',
            'attendee_count' => $event->attendees()->count(),
        ], 200);
    }
}
