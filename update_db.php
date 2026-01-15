<?php
require_once __DIR__ . '/config/db.php';
try {
    $pdo->exec("ALTER TABLE orders ADD COLUMN service_man_id INT DEFAULT NULL");
    $pdo->exec("ALTER TABLE orders ADD FOREIGN KEY (service_man_id) REFERENCES service_men(id)");
    echo "Table altered successfully.";
} catch(PDOException $e) {
    echo "Column likely exists or error: " . $e->getMessage();
}
?>
