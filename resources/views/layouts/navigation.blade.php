<!-- Primary Navigation Menu -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">
        <div class="flex">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('feed') }}" class="flex items-center space-x-2">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    <span class="font-semibold text-lg text-gray-800">VibeFinder</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <x-nav-link href="/" :active="request()->routeIs('/')">
                    {{ __('Лента') }}
                </x-nav-link>
                <x-nav-link :href="route('favorites')" :active="request()->routeIs('favorites')">
                    {{ __('Нравится') }}
                </x-nav-link>
                <x-nav-link :href="route('friends.index')" :active="request()->routeIs('friends.index')">
                    {{ __('Друзья') }}
                </x-nav-link>
                @if(auth()->check() && auth()->user()->isAdmin())
                    <x-nav-link :href="route('admin.events.index')" :active="request()->routeIs('admin.*')" class="text-red-500">
                        {{ __('Админ-панель') }}
                    </x-nav-link>
                @endif
            </div>
        </div>

        <!-- ... остальной код (Settings Dropdown и Hamburger) оставляем как есть ... -->
    </div>
</div>