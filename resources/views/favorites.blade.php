<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Понравившиеся события') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($events->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        <p>Вы еще ничего не лайкнули. Пора найти что-то интересное в <a href="{{ route('feed') }}" class="text-blue-500 hover:underline">Ленте</a>!</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($events as $event)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
                            <img src="{{ asset('storage/' . $event->images[0]) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                            <div class="p-6 flex flex-col flex-grow">
                                <h3 class="text-lg font-bold text-gray-800">{{ $event->title }}</h3>
                                <p class="text-gray-600 mt-2 text-sm flex-grow">{{ Str::limit($event->description, 100) }}</p>
                                
                                <!-- Система голосования -->
                                <div class="mt-4 pt-4 border-t">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm font-medium text-gray-700">Рейтинг друзей:</span>
                                        <span id="avg-rating-{{ $event->id }}" class="text-lg font-bold text-yellow-500">{{ $event->average_rating > 0 ? $event->average_rating : 'N/A' }} <i class="fas fa-star"></i></span>
                                    </div>
                                    <div class="star-rating flex justify-center space-x-1" data-event-id="{{ $event->id }}">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="far fa-star text-2xl text-gray-300 cursor-pointer" data-rating="{{ $i }}"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
    // JS для голосования
    document.querySelectorAll('.star-rating').forEach(rating_element => {
        const stars = rating_element.querySelectorAll('i');
        const eventId = rating_element.dataset.eventId;

        stars.forEach(star => {
            star.addEventListener('mouseover', () => {
                // Подсветка звезд при наведении
                for(let i = 0; i < star.dataset.rating; i++) {
                    stars[i].classList.remove('far', 'text-gray-300');
                    stars[i].classList.add('fas', 'text-yellow-400');
                }
            });

            star.addEventListener('mouseout', () => {
                // Возврат к исходному состоянию
                stars.forEach(s => {
                    s.classList.add('far', 'text-gray-300');
                    s.classList.remove('fas', 'text-yellow-400');
                });
            });

            star.addEventListener('click', async () => {
                const rating = star.dataset.rating;
                
                const response = await fetch(`/api/favorites/event/${eventId}/vote`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ rating })
                });

                const data = await response.json();
                document.getElementById(`avg-rating-${eventId}`).innerText = `${data.average_rating} ⭐`;
                alert('Спасибо за ваш голос!');
            });
        });
    });
    </script>
    @endpush
</x-app-layout>