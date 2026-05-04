<?php
$conn = new mysqli('127.0.0.1', 'root', 'dongle2077', 'eshop_lavarel');
if ($conn->connect_error) die('Connection failed: ' . $conn->connect_error);

echo "--- CATEGORIES ---\n";
$res = $conn->query("SELECT * FROM categories");
while($row = $res->fetch_assoc()) {
    print_r($row);
}

echo "--- PRODUCTS ---\n";
$res = $conn->query("SELECT * FROM products LIMIT 10");
while($row = $res->fetch_assoc()) {
    print_r($row);
}

$conn->close();
