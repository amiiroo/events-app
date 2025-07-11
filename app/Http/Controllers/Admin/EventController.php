<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Tag;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index() {
        $events = Event::latest()->paginate(15);
        return view('admin.events.index', compact('events'));
    }
    
    public function create() {
        $tags = Tag::all();
        return view('admin.events.create', compact('tags'));
    }

    public function store(Request $request) {
        // Добавьте валидацию
        $data = $request->except(['_token', 'tags', 'images']);
        
        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $file) {
                $paths[] = $file->store('events', 'public');
            }
            $data['images'] = $paths;
        }

        $event = Event::create($data);
        $event->tags()->sync($request->tags);

        return redirect()->route('admin.events.index')->with('success', 'Событие создано!');
    }
    
    // Методы edit, update, destroy (аналогично store)
}