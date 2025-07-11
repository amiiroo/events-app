<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(4),
            // Мы будем хранить массив путей. Для примера используем плейсхолдеры.
            'images' => ['https://images.unsplash.com/photo-1610890716171-6b1bb98ffd09?q=80&w=1200&auto=format&fit=crop'],
            'latitude' => $this->faker->latitude(55.6, 55.9), // Координаты в районе Москвы
            'longitude' => $this->faker->longitude(37.4, 37.8),
            'price_category' => $this->faker->numberBetween(1, 3),
            'people_min' => $this->faker->numberBetween(2, 5),
            'people_max' => $this->faker->numberBetween(10, 100),
            'vibe' => $this->faker->randomElement(['Весело', 'Спокойно', 'Активно', 'Творчески', 'Познавательно']),
            'weather_condition' => $this->faker->randomElement(['clear', 'partly-cloudy', 'cloudy', 'overcast', 'drizzle', 'light-rain']),
            'min_temp' => $this->faker->numberBetween(-5, 15),
            'max_temp' => $this->faker->numberBetween(16, 30),
        ];
    }
}
