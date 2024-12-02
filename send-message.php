<?php
require 'vendor/autoload.php'; // Подключение Google Cloud SDK

use Google\Cloud\Storage\StorageClient;

// Получение данных формы
$name = $_POST['name'] ?? ''; // Используйте ?? для установки значений по умолчанию
$email = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

// Проверка на наличие данных
if (empty($name) || empty($email) || empty($message)) {
    die('Bitte füllen Sie alle Felder aus.'); // Сообщение об ошибке, если поля пустые
}

// Инициализация клиента Google Cloud Storage
$storage = new StorageClient([
    'projectId' => 'statikpro',
    'keyFilePath' => 'gs://statikpro/statikpro-490012c2e50c.json' // Укажите локальный путь к вашему JSON-файлу ключа
]);

// Выбор хранилища
$bucketName = 'statikpro'; // Укажите имя вашего бакета
$bucket = $storage->bucket($bucketName);

// Формирование имени файла и содержимого
$fileName = 'messages/' . time() . '.txt'; // Файл будет сохраняться в папку "messages"
$fileContent = "Name: $name\nEmail: $email\nMessage: $message";

// Сохранение файла в облачное хранилище
try {
    $bucket->upload($fileContent, [
        'name' => $fileName
    ]);
    // Ответ пользователю после успешного сохранения
    echo "Vielen Dank für Ihre Nachricht!";
} catch (Exception $e) {
    // Обработка ошибок
    echo 'Fehler: ' . $e->getMessage();
}
?>
