<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService;
use App\Models\Event;

class FeedController extends Controller
{
    // Отображает основную страницу ленты
    public function index()
    {
        return view('feed');
    }
    
    // API-метод для получения следующего события
    public function getNextEvent(Request $request, WeatherService $weatherService)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ]);

        $weather = $weatherService->getForecast($request->lat, $request->lon);
        
        $swipedIds = auth()->user()->swipes()->pluck('event_id');

        $eventQuery = Event::with('tags')
                            ->whereNotIn('id', $swipedIds);

        // Фильтрация по погоде, если данные получены
        if ($weather && isset($weather['condition'], $weather['temp'])) {
             $eventQuery->where(function ($query) use ($weather) {
                $query->whereNull('weather_condition') // События для любой погоды
                      ->orWhere(function ($q) use ($weather) {
                          $q->where('weather_condition', $weather['condition'])
                            ->where('min_temp', '<=', $weather['temp'])
                            ->where('max_temp', '>=', $weather['temp']);
                      });
            });
        }
        
        $event = $eventQuery->inRandomOrder()->first();

        if ($event) {
            // Возвращаем отрендеренный HTML-компонент карточки
            return response()->view('components.event-card', compact('event'));
        }

        return response()->json(null); // Если событий больше нет
    }
    
    // API-метод для обработки лайка/дизлайка
    public function swipe(Request $request, Event $event)
    {
        $request->validate(['liked' => 'required|boolean']);
        
        Swipe::updateOrCreate(
            ['user_id' => auth()->id(), 'event_id' => $event->id],
            ['liked' => $request->liked]
        );
        
        return response()->json(['status' => 'success']);
    }
}