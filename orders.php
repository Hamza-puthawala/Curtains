<?php include 'includes/header.php'; 
if (!isLoggedIn()) redirect('login.php');
?>
<h2>My Orders</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$_SESSION['user_id']]);
        while ($row = $stmt->fetch()):
        ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= inr($row['total_amount']) ?></td>
            <td><?= $row['order_status'] ?></td>
            <td><?= $row['created_at'] ?></td>
            <td>
                <a href="track_order.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">Track</a>
                <!-- Show QR if needed -->
                <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#qrModal<?= $row['id'] ?>">Show QR</button>
                
                <div class="modal fade" id="qrModal<?= $row['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header"><h5 class="modal-title">Order QR Code</h5></div>
                            <div class="modal-body text-center">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= $row['qr_token'] ?>">
                                <p class="mt-2">Show this to the delivery person.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include 'includes/footer.php'; ?>
