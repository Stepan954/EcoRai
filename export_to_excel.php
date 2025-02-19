<?php
require_once 'libs/PhpSpreadsheet/src/autoload.php';

// Использование правильного namespace
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

// Получение данных из таблицы
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
$spreadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet();

// Заголовки столбцов
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Имя');
$sheet->setCellValue('C1', 'Телефон');
$sheet->setCellValue('D1', 'Услуга');
$sheet->setCellValue('E1', 'Дата заказа');

// Заполнение данными
$row = 2;
while($row_data = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $row, $row_data['id']);
    $sheet->setCellValue('B' . $row, $row_data['name']);
    $sheet->setCellValue('C' . $row, $row_data['phone']);
    $sheet->setCellValue('D' . $row, $row_data['service']);
    $sheet->setCellValue('E' . $row, $row_data['created_at']);
    $row++;
}

// Сохранение файла
$writer = new Xlsx($spreadsheet);
$writer->save('orders.xlsx');

echo "Данные экспортированы в orders.xlsx";
$conn->close();
?>