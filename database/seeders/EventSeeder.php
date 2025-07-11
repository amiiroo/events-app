<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Получаем все существующие теги
        $tags = Tag::all();

        // Создаем 20 случайных событий
        Event::factory(20)->create()->each(function ($event) use ($tags) {
            // Каждому событию привязываем от 1 до 3 случайных тегов
            $event->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        // Создаем одно конкретное событие для примера
        Event::factory()->create([
            'title' => 'Настольные игры в уютном кафе',
            'description' => 'Приглашаем всех желающих на вечер настольных игр! У нас есть большая коллекция, от классики до новинок. Приходите с друзьями или найдите их на месте!',
            'images' => ['https://images.unsplash.com/photo-1610890716171-6b1bb98ffd09?q=80&w=1200&auto=format&fit=crop'],
            'latitude' => 55.7522,
            'longitude' => 37.6156,
            'price_category' => 1,
            'people_min' => 2,
            'people_max' => 12,
            'vibe' => 'Общение',
            'weather_condition' => null, // Подходит для любой погоды
            'min_temp' => null,
            'max_temp' => null,
        ])->tags()->attach(Tag::whereIn('slug', ['board-games', 'food'])->pluck('id'));
    }
}
