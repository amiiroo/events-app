<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Создаем Админа
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);
        
        // Создаем обычного пользователя
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'user@example.com',
            'role' => 'user',
            'password' => bcrypt('password'),
        ]);
        
        // Запускаем сидеры для тегов и мероприятий
        $this->call([
            TagSeeder::class,
            EventSeeder::class,
        ]);
    }
}
