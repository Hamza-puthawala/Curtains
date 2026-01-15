<?php include 'includes/header.php'; 

if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $pdo->prepare("UPDATE orders SET order_status = ? WHERE id = ?")->execute([$status, $order_id]);
    setFlash('success', 'Order status updated.');
    // Refresh to see changes
    echo "<script>window.location.href='orders.php';</script>";
}

?>
<h2>Orders</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>User</th>
            <th>Total</th>
            <th>Status</th>
            <th>Payment</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT o.*, u.name as user_name FROM orders o LEFT JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC";
        $stmt = $pdo->query($sql);
        while ($row = $stmt->fetch()):
        ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['user_name']) ?></td>
            <td><?= inr($row['total_amount']) ?></td>
            <td>
                <span class="badge bg-<?= $row['order_status'] == 'Delivered' ? 'success' : ($row['order_status'] == 'Cancelled' ? 'danger' : 'warning') ?>">
                    <?= $row['order_status'] ?>
                </span>
            </td>
            <td><?= $row['payment_status'] ?> (<?= $row['payment_method'] ?>)</td>
            <td><?= $row['created_at'] ?></td>
            <td>
                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#orderModal<?= $row['id'] ?>">View</button>
                
                <!-- Modal -->
                <div class="modal fade" id="orderModal<?= $row['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Order #<?= $row['id'] ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <h6>Items:</h6>
                                <ul>
                                <?php
                                $items = $pdo->prepare("SELECT oi.*, p.name FROM order_items oi LEFT JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
                                $items->execute([$row['id']]);
                                while($item = $items->fetch()){
                                    echo "<li>{$item['name']} - {$item['quantity']} x " . inr($item['price']) . "</li>";
                                }
                                ?>
                                </ul>
                                <hr>
                                <form method="POST">
                                    <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                                    <label>Update Status:</label>
                                    <select name="status" class="form-select mb-2">
                                        <option value="Pending" <?= $row['order_status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="Processing" <?= $row['order_status'] == 'Processing' ? 'selected' : '' ?>>Processing</option>
                                        <option value="Out for Delivery" <?= $row['order_status'] == 'Out for Delivery' ? 'selected' : '' ?>>Out for Delivery</option>
                                        <option value="Delivered" <?= $row['order_status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                                        <option value="Cancelled" <?= $row['order_status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                    </select>
                                    <button type="submit" name="update_status" class="btn btn-primary">Update</button>
                                </form>
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
