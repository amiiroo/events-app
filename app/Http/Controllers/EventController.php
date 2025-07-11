<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Показывает список всех событий.
     */
    public function index()
    {
        $events = Event::latest()->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Показывает форму для создания нового события.
     */
    public function create()
    {
        $tags = Tag::all();
        return view('admin.events.create', compact('tags'));
    }

    /**
     * Сохраняет новое событие в базе данных.
     */
    public function store(Request $request)
    {
        $validated = $this->validateEvent($request);

        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $file) {
                // Сохраняем в storage/app/public/events
                $paths[] = $file->store('events', 'public');
            }
            $validated['images'] = $paths;
        }

        $event = Event::create($validated);
        $event->tags()->sync($request->input('tags', []));

        return redirect()->route('admin.events.index')->with('success', 'Событие успешно создано!');
    }

    /**
     * Показывает форму для редактирования события.
     */
    public function edit(Event $event)
    {
        $tags = Tag::all();
        $event->load('tags'); // Загружаем связанные теги
        return view('admin.events.edit', compact('event', 'tags'));
    }

    /**
     * Обновляет событие в базе данных.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $this->validateEvent($request, $event->id);

        if ($request->hasFile('images')) {
            // Удаляем старые изображения перед загрузкой новых
            if ($event->images) {
                foreach ($event->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            
            $paths = [];
            foreach ($request->file('images') as $file) {
                $paths[] = $file->store('events', 'public');
            }
            $validated['images'] = $paths;
        }

        $event->update($validated);
        $event->tags()->sync($request->input('tags', []));

        return redirect()->route('admin.events.index')->with('success', 'Событие успешно обновлено!');
    }

    /**
     * Удаляет событие из базы данных.
     */
    public function destroy(Event $event)
    {
        // Удаляем связанные изображения
        if ($event->images) {
            foreach ($event->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Событие успешно удалено!');
    }

    /**
     * Хелпер для валидации данных из формы.
     */
    private function validateEvent(Request $request, $eventId = null): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => ($eventId ? 'nullable' : 'required') . '|array', // Обязательно при создании
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'price_category' => 'required|integer|in:1,2,3',
            'people_min' => 'required|integer|min:1',
            'people_max' => 'required|integer|gte:people_min',
            'vibe' => 'required|string|max:50',
            'weather_condition' => 'nullable|string',
            'min_temp' => 'nullable|integer',
            'max_temp' => 'nullable|integer|gte:min_temp',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);
    }
}

