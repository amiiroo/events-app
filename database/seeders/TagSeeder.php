<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::create([
            'name' => 'Фестиваль',
            'slug' => 'festival',
        ]);
        Tag::create([
            'name' => 'Концерт',
            'slug' => 'concert',
        ]);
        Tag::create([
            'name' => 'Танец',
            'slug' => 'dance',
        ]);
        Tag::create([
            'name' => 'Спорт',
            'slug' => 'sport',
        ]);
    }
}
