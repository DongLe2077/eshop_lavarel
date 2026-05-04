<?php
$conn = new mysqli('127.0.0.1', 'root', 'dongle2077', 'eshop_lavarel');
if ($conn->connect_error) die('Connection failed: ' . $conn->connect_error);

$colsNeeded = [
    'first_name' => 'VARCHAR(255) NULL',
    'last_name' => 'VARCHAR(255) NULL',
    'email' => 'VARCHAR(255) NULL',
    'phone' => 'VARCHAR(20) NULL',
    'address' => 'TEXT NULL',
    'city' => 'VARCHAR(255) NULL',
    'zip' => 'VARCHAR(20) NULL',
    'total_price' => 'DOUBLE NULL'
];

foreach ($colsNeeded as $col => $def) {
    $check = $conn->query("SHOW COLUMNS FROM `order` LIKE '$col'");
    if ($check->num_rows == 0) {
        if ($conn->query("ALTER TABLE `order` ADD `$col` $def")) {
            echo "Added column: $col\n";
        } else {
            echo "Error adding $col: " . $conn->error . "\n";
        }
    } else {
        echo "Column already exists: $col\n";
    }
}

$conn->close();
echo "Done.\n";
