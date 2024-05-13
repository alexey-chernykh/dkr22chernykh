<?php
include 'dbconnect.php';

// Назва сторінки
$page_name = 'page';

// Чи вже є запис про сторінку в базі даних
$stmt = $pdo->prepare("SELECT * FROM page_views WHERE page_name = ?");
$stmt->execute([$page_name]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    // Якщо запис відсутній, додаємо її з початковим значенням кількості переглядів
    $stmt = $pdo->prepare("INSERT INTO page_views (page_name, view_count) VALUES (?, 0)");
    $stmt->execute([$page_name]);
}

// Збільшуємо лічильник
$stmt = $pdo->prepare("UPDATE page_views SET view_count = view_count + 1 WHERE page_name = ?");
$stmt->execute([$page_name]);

// Отримуємо поточне значення лічильника переглядів
$stmt = $pdo->prepare("SELECT view_count FROM page_views WHERE page_name = ?");
$stmt->execute([$page_name]);
$view_count = $stmt->fetchColumn();

echo "Число переглядів сторінки \"$page_name\": $view_count";
?>
