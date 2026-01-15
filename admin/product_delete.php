<?php
require_once __DIR__ . '/../../includes/functions.php';
if (!isAdmin()) redirect('../login.php');

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    setFlash('success', 'Product deleted.');
}
redirect('products.php');
?>
