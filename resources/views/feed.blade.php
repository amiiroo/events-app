// resources/views/feed.blade.php

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cardContainer = document.getElementById('card-container');
        const controlsContainer = document.getElementById('controls-container');
        const loader = document.getElementById('loader');
        const noMoreEventsEl = document.getElementById('no-more-events');

        const options = {
            enableHighAccuracy: true, // Повышенная точность
            timeout: 10000,           // Тайм-аут 10 секунд
            maximumAge: 0             // Не использовать кэшированные данные
        };

        const successCallback = (position) => {
            console.log("Геолокация получена успешно:", position.coords);
            loader.innerHTML = '<p>Подбираем для вас лучшие события...</p>';
            fetchAndRenderNextEvent(position.coords.latitude, position.coords.longitude);
        };

        const errorCallback = (error) => {
            console.error("Ошибка геолокации:", error);
            let errorMessage = 'Не удалось определить ваше местоположение.';
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage = "Вы заблокировали доступ к геолокации. Пожалуйста, разрешите его в настройках браузера.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage = "Информация о местоположении недоступна.";
                    break;
                case error.TIMEOUT:
                    errorMessage = "Истекло время ожидания запроса геолокации.";
                    break;
            }
            loader.innerHTML = `<p class="text-red-500">${errorMessage}</p>`;
        };
        
        // ... остальной код (fetchAndRenderNextEvent, swipe) остается без изменений ...
        
        // Запускаем процесс при загрузке страницы
        if (navigator.geolocation) {
            console.log("Запрос геолокации...");
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback, options);
        } else {
            console.log(123123)
            loader.innerText = 'Геолокация не поддерживается вашим браузером.';
        }
    });
</script>
@endpush