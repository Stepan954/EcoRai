<?php
// Параметры подключения к базе данных
$servername = "localhost"; // Обычно это localhost
$username = "ecorai_user"; // Имя пользователя базы данных
$password = "eco123456"; // Пароль пользователя базы данных
$dbname = "ecorai_orders"; // Имя базы данных

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение данных из формы
$name = $_POST['name'];
$phone = $_POST['phone'];
$service = $_POST['service'];

// Вставка данных в таблицу
$stmt = $conn->prepare("INSERT INTO orders (name, phone, service) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $phone, $service);

if ($stmt->execute()) {
    echo "Данные успешно сохранены!";
} else {
    echo "Ошибка: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>