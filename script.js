// Простой таймер обратного отсчета
function updateCountdown() {
    const countdownDate = new Date("2025-05-03T17:00:00").getTime();
    const now = new Date().getTime();
    const distance = countdownDate - now;

    if (distance < 0) {
        // Если дата уже прошла
        document.getElementById("days").textContent = "0";
        document.getElementById("hours").textContent = "0";
        document.getElementById("minutes").textContent = "0";
        document.getElementById("seconds").textContent = "0";
        clearInterval(timer); // Останавливаем таймер
        // Добавляем сообщение
        const countdownElement = document.querySelector('.countdown');
        const message = document.createElement('div');
        message.textContent = "Свадьба началась!";
        message.style.fontSize = "24px";
        message.style.fontWeight = "bold";
        message.style.color = "#983e70";
        countdownElement.appendChild(message);
        return;
    }

    // Вычисляем дни, часы, минуты и секунды
    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Обновляем элементы на странице
    document.getElementById("days").textContent = days;
    document.getElementById("hours").textContent = hours;
    document.getElementById("minutes").textContent = minutes;
    document.getElementById("seconds").textContent = seconds;
}

// Обновляем обратный отсчет каждую секунду
const timer = setInterval(updateCountdown, 1000);
updateCountdown();

// Инициализация Яндекс Карт
ymaps.ready(init);

function init() {
    var myMap = new ymaps.Map("map", {
        center: [51.669257, 39.222045], // Координаты Сабуров Холл
        zoom: 16, // Масштаб карты
        controls: ['zoomControl', 'fullscreenControl']
    });

    var myPlacemark = new ymaps.Placemark([51.669257, 39.222045], {
        hintContent: 'Сабуров Холл',
        balloonContent: 'ул. Пролетарская, 87в, 7-й этаж, Воронеж, Воронежская обл., 394036'
    });

    myMap.geoObjects.add(myPlacemark);
}