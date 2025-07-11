<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.weather.yandex.ru/v2/forecast';

    public function __construct()
    {
        $this->apiKey = config('services.yandex_weather.key');
    }

    public function getForecast(float $lat, float $lon): ?array
    {
        if (!$this->apiKey) {
            Log::error('Yandex Weather API key not set.');
            return null;
        }

        $response = Http::withHeaders(['X-Yandex-Weather-Key' => $this->apiKey])
                        ->get($this->baseUrl, ['lat' => $lat, 'lon' => $lon, 'lang' => 'ru_RU']);

        if ($response->successful()) {
            return $response->json()['fact']; // Возвращаем только фактическую погоду
        }
        
        Log::error('Yandex Weather API request failed.', ['status' => $response->status(), 'body' => $response->body()]);
        return null;
    }
}