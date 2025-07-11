<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'description',
        'images',
        'latitude',
        'longitude',
        'price_category',
        'people_min',
        'people_max',
        'vibe',
        'weather_condition',
        'min_temp',
        'max_temp',
    ];

    /**
     * Приведение типов атрибутов.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'images' => 'array', // Laravel будет автоматически кодировать/декодировать это поле в JSON
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'price_category' => 'integer',
        'people_min' => 'integer',
        'people_max' => 'integer',
        'min_temp' => 'integer',
        'max_temp' => 'integer',
    ];

    protected $guarded = []; // Разрешаем массовое заполнение всех полей

    
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // Вычисляемое свойство для получения среднего рейтинга
    public function getAverageRatingAttribute(): float
    {
        // Округляем до одного знака после запятой
        return round($this->votes()->avg('rating'), 1);
    }
}