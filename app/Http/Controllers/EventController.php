<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type');
        $query = Event::orderBy('event_date', 'asc');

        if ($type && $type !== 'all') {
            $query->where('event_type', $type);
        }

        $events = $query->paginate(9)->withQueryString();
        $eventTypes = Event::select('event_type')->distinct()->pluck('event_type');

        return view('pages.events', compact('events', 'eventTypes', 'type'));
    }

    public function register(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:20',
            'books_to_exchange' => 'nullable|string|max:255',
        ]);

        EventRegistration::create([
            'event_id' => $event->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'books_to_exchange' => $request->books_to_exchange,
        ]);

        $event->increment('attendees_count');

        return redirect()->back()->with('success', "RSVP confirmed! You are successfully registered for {$event->title}. We look forward to seeing you at the book exchange!");
    }
}
