<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Vote;

class FavoriteController extends Controller
{
    public function index()
    {
        $events = auth()->user()->favoriteEvents()->with('votes')->latest()->get();
        return view('favorites', compact('events'));
    }

    public function vote(Request $request, Event $event)
    {
        $request->validate(['rating' => 'required|integer|min:1|max:5']);

        Vote::updateOrCreate(
            ['user_id' => auth()->id(), 'event_id' => $event->id],
            ['rating' => $request->rating]
        );
        
        // Возвращаем новый средний рейтинг
        return response()->json(['average_rating' => $event->fresh()->average_rating]);
    }
}