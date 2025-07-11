<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Друзья') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Список друзей -->
            <div class="md:col-span-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium mb-4">Ваши друзья</h3>
                    @forelse($friends as $friend)
                        <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded">
                            <span>{{ $friend->name }} (@ {{ $friend->username }})</span>
                            {{-- Кнопка удаления --}}
                        </div>
                    @empty
                        <p>У вас пока нет друзей.</p>
                    @endforelse
                </div>
            </div>

            <!-- Запросы и поиск -->
            <div>
                 <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-medium mb-4">Запросы в друзья</h3>
                     {{-- Здесь выводим $pendingRequests с кнопками принять/отклонить --}}
                 </div>
                 <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium mb-4">Найти друзей</h3>
                     {{-- Форма для поиска друзей --}}
                 </div>
            </div>

        </div>
    </div>
</x-app-layout>