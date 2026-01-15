<?php 
require_once 'includes/functions.php';
if (!isLoggedIn()) {
    setFlash('warning', 'Please login to checkout.');
    redirect('login.php');
}

$cart = $_SESSION['cart'] ?? [];
if(empty($cart)) redirect('cart.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = $_POST['payment_method'];
    
    // Calculate total
    $ids = implode(',', array_keys($cart));
    $products = $pdo->query("SELECT * FROM products WHERE id IN ($ids)")->fetchAll();
    $total = 0;
    foreach($products as $p) {
        $total += $p['price'] * $cart[$p['id']];
    }
    
    // Insert Order
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, payment_method, payment_status, qr_token, qr_expires_at) VALUES (?, ?, ?, ?, ?, ?)");
    $qr_token = bin2hex(random_bytes(16));
    $payment_status = ($payment_method == 'Online') ? 'Paid' : 'Pending';
    $qr_expires_at = date('Y-m-d H:i:s', strtotime('+7 days'));
    
    $stmt->execute([$_SESSION['user_id'], $total, $payment_method, $payment_status, $qr_token, $qr_expires_at]);
    $order_id = $pdo->lastInsertId();
    
    // Insert Items
    $stmt_item = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach($products as $p) {
        $stmt_item->execute([$order_id, $p['id'], $cart[$p['id']], $p['price']]);
        // Update stock (optional but good)
        $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?")->execute([$cart[$p['id']], $p['id']]);
    }
    
    // Send Email with QR
    $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . $qr_token;
    $user_email = $pdo->query("SELECT email FROM users WHERE id=" . $_SESSION['user_id'])->fetchColumn();
    $subject = "Order #$order_id Confirmed";
    $displayTotal = inr($total);
    $content = "
        <h1>Thank you for your order!</h1>
        <p>Your order #$order_id has been placed successfully.</p>
        <p>Total: $displayTotal</p>
        <p><strong>Your Delivery QR Code:</strong></p>
        <img src='$qr_url' alt='QR Code' />
        <p>Please show this QR code to the delivery person upon arrival.</p>
    ";
    
    sendEmail($user_email, $_SESSION['user_name'], $subject, $content);
    
    // Clear Cart
    unset($_SESSION['cart']);
    setFlash('success', 'Order placed successfully! Check your email for the QR code.');
    redirect('orders.php');
}

include 'includes/header.php';
?>

<h2>Checkout</h2>
<div class="row">
    <div class="col-md-6">
        <form method="POST">
            <h4>Payment Method</h4>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" value="COD" checked>
                <label class="form-check-label">Cash on Delivery</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" value="Online">
                <label class="form-check-label">Online Payment (Mock)</label>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary btn-lg">Place Order</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
