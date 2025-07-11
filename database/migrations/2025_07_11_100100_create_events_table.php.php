<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('images'); // Будем хранить JSON-массив путей к картинкам
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->enum('price_category', [1, 2, 3])->comment('1 = $, 2 = $$, 3 = $$$');
            $table->integer('people_min');
            $table->integer('people_max');
            $table->string('vibe'); // Весело, Спокойно и т.д.
            // Условия погоды
            $table->string('weather_condition')->nullable()->comment('clear, partly-cloudy, etc.');
            $table->integer('min_temp')->nullable();
            $table->integer('max_temp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
