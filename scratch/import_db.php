<?php
// Script to import SQL file to TiDB Cloud
$host = 'gateway01.ap-southeast-1.prod.alicloud.tidbcloud.com';
$port = 4000;
$user = 'ZU1iYpRLNd1TLZm.root';
$pass = 'vAhPKJKVzlO6H9B3';
$db   = 'eshop_lavarel';
$ca   = __DIR__ . '/../isrgrootx1.pem';
$sqlFile = __DIR__ . '/../dbeshop.sql';

mysqli_report(MYSQLI_REPORT_OFF); // Turn off for manual handling

try {
    $conn = mysqli_init();
    mysqli_ssl_set($conn, NULL, NULL, $ca, NULL, NULL);
    
    echo "Dang ket noi toi TiDB...\n";
    if (!mysqli_real_connect($conn, $host, $user, $pass, $db, $port, NULL, MYSQLI_CLIENT_SSL)) {
        die("Ket noi that bai: " . mysqli_connect_error());
    }
    echo "Ket noi thanh cong!\n";

    echo "Dang doc file SQL...\n";
    $sql = file_get_contents($sqlFile);
    
    echo "Dang thuc thi multi_query...\n";
    if (mysqli_multi_query($conn, $sql)) {
        do {
            if ($result = mysqli_store_result($conn)) {
                mysqli_free_result($result);
            }
            if (!mysqli_more_results($conn)) break;
        } while (mysqli_next_result($conn));
    }

    if (mysqli_error($conn)) {
        echo "LOI: " . mysqli_error($conn) . "\n";
    } else {
        echo "=== IMPORT THANH CONG! ===\n";
    }
    
    $conn->close();
} catch (Exception $e) {
    echo "LOI: " . $e->getMessage() . "\n";
}
