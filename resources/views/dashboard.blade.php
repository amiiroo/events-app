<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Лента') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8"> <!-- Уменьшена максимальная ширина -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @foreach(\App\Models\Event::with('tags')->get() as $event)
                    <div class="activity-card mb-6 max-w-lg mx-auto"> <!-- Добавлен отступ между карточками -->
                        <div class="media-section">
                            @if(!empty($event->images))
                                <div class="media-content image-view active-media" style="background-image: url('{{ asset($event->images[0]) }}')">
                                    <div class="weather">
                                        @if($event->min_temp || $event->max_temp)
                                            <i class="fas fa-sun"></i>
                                            {{ $event->min_temp ? $event->min_temp . '°' : '' }}
                                            {{ $event->min_temp && $event->max_temp ? ' - ' : '' }}
                                            {{ $event->max_temp ? $event->max_temp . '°' : '' }}
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="info-section">
                            <h2 class="title">{{ $event->title }}</h2>
                            <div class="details">
                                <span class="date">{{ $event->created_at->format('d.m') }}</span>
                            </div>
                            <div class="tags">
                                @if($event->people_min || $event->people_max)
                                    <span class="tag">
                                        <i class="fas fa-users"></i>
                                        {{ $event->people_min }}-{{ $event->people_max }}
                                    </span>
                                @endif

                                @if($event->vibe)
                                    <span class="tag">
                                        <i class="far fa-laugh-beam"></i>
                                        {{ $event->vibe }}
                                    </span>
                                @endif

                                @foreach($event->tags as $tag)
                                    <span class="tag">#{{ $tag->name }}</span>
                                @endforeach

                                @if($event->price_category !== null)
                                    <span class="tag">
                                        <i class="fas fa-dollar-sign"></i>
                                        {{ str_repeat('$', $event->price_category + 1) }}
                                    </span>
                                @endif

                                @if($event->weather_condition)
                                    <span class="tag">
                                        <i class="fas fa-cloud"></i>
                                        {{ $event->weather_condition }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="description-section">
                            <p>{{ $event->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Подключаем Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Подключаем шрифт Montserrat -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap');

        /* Основные переменные */
        :root {
            --bg-light-gray: #f0f0f0;
            --card-bg: #ffffff;
            --header-bg: #d0d0d0;
            --text-dark: #333;
            --text-medium: #666;
            --primary-blue: #007bff;
            --accent-green: #4CAF50;
            --accent-red: #F44336;
            --border-radius-default: 15px;
            --border-radius-large: 25px;
            --shadow-light: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Стили карточки активности */
        .activity-card {
            background-color: var(--card-bg);
            border-radius: var(--border-radius-default);
            box-shadow: var(--shadow-light);
            overflow: hidden;
            font-family: 'Montserrat', sans-serif;
            width: 100%;
            max-width: 32rem; /* Максимальная ширина карточки */
            margin: 0 auto; /* Центрирование */
        }

        /* Секция с медиа */
        .media-section {
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
        }

        .media-content {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
        }

        /* Погода */
        .weather {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: var(--border-radius-default);
            padding: 5px 10px;
            font-size: 0.9em;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
            color: var(--text-dark);
        }

        .weather i {
            color: orange;
        }

        /* Информационная секция */
        .info-section {
            padding: 15px;
            padding-bottom: 10px;
        }

        .info-section .title {
            font-size: 1.3em;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text-dark);
        }

        .info-section .details {
            display: flex;
            flex-wrap: wrap;
            gap: 5px 10px;
            font-size: 0.85em;
            color: var(--text-medium);
            margin-bottom: 10px;
        }

        /* Теги */
        .tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .tag {
            background-color: var(--bg-light-gray);
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 0.8em;
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }

        .tag i {
            color: var(--text-medium);
        }

        .tag .fa-dollar-sign {
            color: var(--accent-green);
        }

        /* Секция описания */
        .description-section {
            padding: 0 15px 15px;
        }

        .description-section p {
            font-size: 0.95em;
            line-height: 1.4;
            color: var(--text-dark);
        }

        /* Адаптивность */
        @media (max-width: 480px) {
            .info-section, .description-section {
                padding: 10px;
            }
            .info-section .title {
                font-size: 1.2em;
            }
        }
    </style>
</x-app-layout>