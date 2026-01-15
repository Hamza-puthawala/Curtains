<?php
require_once '../config/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['qr_token'] ?? '';
    
    if (empty($token)) {
        echo json_encode(['success' => false, 'message' => 'Token is required.']);
        exit;
    }
    
    // Find order
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE qr_token = ?");
    $stmt->execute([$token]);
    $order = $stmt->fetch();
    
    if (!$order) {
        echo json_encode(['success' => false, 'message' => 'Invalid QR Token.']);
        exit;
    }
    
    if ($order['order_status'] === 'Delivered') {
        echo json_encode(['success' => false, 'message' => 'Order already delivered.']);
        exit;
    }
    
    if (strtotime($order['qr_expires_at']) < time()) {
        echo json_encode(['success' => false, 'message' => 'QR Code has expired.']);
        exit;
    }
    
    // Update status
    $update = $pdo->prepare("UPDATE orders SET order_status = 'Delivered', payment_status = 'Paid' WHERE id = ?");
    if ($update->execute([$order['id']])) {
        echo json_encode(['success' => true, 'message' => 'Delivery Confirmed! Order #' . $order['id'] . ' updated.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid Request.']);
}
?>
