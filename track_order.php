<?php include 'includes/header.php'; 
if (!isLoggedIn()) redirect('login.php');
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$order = $stmt->fetch();

if(!$order) {
    echo "Order not found.";
    include 'includes/footer.php';
    exit;
}
?>
<h2>Track Order #<?= $order['id'] ?></h2>
<div class="progress" style="height: 30px;">
    <?php
    $status = $order['order_status'];
    $val = 0;
    if($status == 'Pending') $val = 25;
    elseif($status == 'Processing') $val = 50;
    elseif($status == 'Out for Delivery') $val = 75;
    elseif($status == 'Delivered') $val = 100;
    ?>
    <div class="progress-bar bg-success" role="progressbar" style="width: <?= $val ?>%"><?= $status ?></div>
</div>
<div class="mt-4">
    <p><strong>Current Status:</strong> <?= $status ?></p>
    <p><strong>Order Date:</strong> <?= $order['created_at'] ?></p>
</div>
<?php include 'includes/footer.php'; ?>
