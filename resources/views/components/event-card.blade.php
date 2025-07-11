<div class="event-card absolute inset-0 bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col" data-event-id="{{ $event->id }}">
    <!-- Секция с картинками (карусель) -->
    <div class="relative flex-shrink-0">
        <!-- Здесь можно реализовать карусель, если картинок несколько -->
        <img src="{{ asset('storage/' . $event->images[0]) }}" alt="{{ $event->title }}" class="w-full h-80 object-cover">
        
        <!-- Оверлей с погодой -->
        <div class="absolute top-4 right-4 bg-white/80 backdrop-blur-sm p-2 rounded-full text-sm font-semibold flex items-center">
            <i class="fas fa-sun text-yellow-500 mr-2"></i>
            <span>+24°</span>
        </div>
    </div>

    <!-- Основной контент -->
    <div class="p-5 flex-grow flex flex-col">
        <h2 class="text-2xl font-bold text-gray-800">{{ $event->title }}</h2>
        <p class="text-gray-600 mt-2 text-sm leading-relaxed flex-grow">{{ $event->description }}</p>

        <!-- Теги -->
        <div class="flex flex-wrap gap-2 mt-4">
            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-1 rounded-full"><i class="fas fa-users mr-1"></i> {{ $event->people_min }}-{{ $event->people_max }}</span>
            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-1 rounded-full">{{ str_repeat('$', $event->price_category) }}</span>
            <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $event->vibe }}</span>
            @foreach($event->tags as $tag)
                <span class="bg-gray-200 text-gray-800 text-xs font-semibold px-2.5 py-1 rounded-full">#{{ $tag->name }}</span>
            @endforeach
        </div>
    </div>
</div>