<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = '127.0.0.1';
$port = 3306;
$user = 'root';
$pass = 'dongle2077';

try {
    $conn = new mysqli($host, $user, $pass, '', $port);
    echo "=== KET NOI THANH CONG ===\n\n";
    
    // List databases
    $result = $conn->query("SHOW DATABASES");
    echo "DATABASES:\n";
    while ($row = $result->fetch_row()) {
        echo "  - " . $row[0] . "\n";
    }
    
    // Use eshop_laravel
    $conn->select_db('eshop_lavarel');
    echo "\n=== CAU TRUC BANG TRONG eshop_lavarel ===\n";
    $tables = $conn->query("SHOW TABLES");
    while ($row = $tables->fetch_row()) {
        $tableName = $row[0];
        echo "\n--- BANG: $tableName ---\n";
        $cols = $conn->query("DESCRIBE `$tableName`");
        while ($col = $cols->fetch_assoc()) {
            $def = $col['Default'] ?? 'NULL';
            echo "  {$col['Field']} | {$col['Type']} | Null:{$col['Null']} | Key:{$col['Key']} | Default:$def\n";
        }
        $count = $conn->query("SELECT COUNT(*) as cnt FROM `$tableName`")->fetch_assoc();
        echo "  >> So dong: {$count['cnt']}\n";
    }
    
    $conn->close();
} catch (Exception $e) {
    echo "LOI: " . $e->getMessage() . "\n";
}
