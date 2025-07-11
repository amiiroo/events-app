<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Лента') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach(\App\Models\Event::with('tags')->get() as $event)
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden">
                            @if(!empty($event->images))
                                <img src="{{ asset($event->images[0]) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                            @endif
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $event->title }}</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-3">{{ Str::limit($event->description, 100) }}</p>
                                
                                <div class="flex flex-wrap gap-2 mb-3">
                                    @foreach($event->tags as $tag)
                                        <span class="px-2 py-1 bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-100 rounded-full text-xs">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>

                                <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                    <p><span class="font-medium">Цена:</span> {{ ['Бесплатно', 'Низкая', 'Средняя', 'Высокая'][$event->price_category] }}</p>
                                    <p><span class="font-medium">Участники:</span> {{ $event->people_min }}-{{ $event->people_max }} человек</p>
                                    <p><span class="font-medium">Атмосфера:</span> {{ $event->vibe }}</p>
                                    @if($event->weather_condition)
                                        <p><span class="font-medium">Погода:</span> {{ $event->weather_condition }}</p>
                                    @endif
                                    @if($event->min_temp || $event->max_temp)
                                        <p><span class="font-medium">Температура:</span> 
                                            {{ $event->min_temp ? $event->min_temp . '°C' : '' }}
                                            {{ $event->min_temp && $event->max_temp ? ' - ' : '' }}
                                            {{ $event->max_temp ? $event->max_temp . '°C' : '' }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>