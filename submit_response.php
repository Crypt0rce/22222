<?php
// submit_response.php

// Подключаем файл с конфигурацией (если вы используете отдельный файл для конфигурации)
// include 'includes/config.php';

// Если вы не используете отдельный файл для конфигурации, можно вставить значения напрямую
$botToken = "7799287983:AAG_sqKmFxlud5Jq1TrTDwv9_4PQPIQ1S84"; // Ваш токен бота
$chatId = "409368757"; // Ваш chat_id

// Проверка метода запроса
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Недопустимый запрос.";
    exit();
}

// Проверка CSRF токена
session_start();
if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    echo "Недопустимый запрос.";
    exit();
}

// Получаем и фильтруем данные из формы
$name = htmlspecialchars(trim($_POST['name']));
$response = htmlspecialchars(trim($_POST['response']));
$guests = intval($_POST['guests']);
$message = htmlspecialchars(trim($_POST['message']));

// Подготовка сообщения для Telegram
$text = "Новый ответ на приглашение:\n\nИмя: $name\nОтвет: $response\nКоличество гостей: $guests\nСообщение: $message";

// Используем cURL для отправки POST-запроса
$apiUrl = "https://api.telegram.org/bot$botToken/sendMessage";
$data = [
    'chat_id' => $chatId,
    'text' => $text
];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
if ($result === FALSE) {
    // Обработка ошибки
    echo "Произошла ошибка при отправке сообщения: " . curl_error($ch);
} else {
    $response = json_decode($result, true);
    if ($response['ok']) {
        // Перенаправляем пользователя на страницу с благодарностью
        header("Location: thank_you.html");
        exit();
    } else {
        // Обработка ошибки от Telegram
        echo "Ошибка от Telegram: " . $response['description'];
    }
}
curl_close($ch);
?>