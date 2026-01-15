<?php include 'includes/header.php'; 

if (isset($_POST['assign_task'])) {
    $order_id = $_POST['order_id'];
    $service_man_id = $_POST['service_man_id'];
    $pdo->prepare("UPDATE orders SET service_man_id = ?, order_status = 'Processing' WHERE id = ?")->execute([$service_man_id, $order_id]);
    setFlash('success', 'Task assigned to Service Man.');
}

$service_men = $pdo->query("SELECT * FROM service_men WHERE active=1")->fetchAll();
?>
<h2>Manage Orders & Assign Tasks</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>User</th>
            <th>Status</th>
            <th>Assigned To</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT o.*, u.name as user_name, s.name as service_man_name FROM orders o 
                LEFT JOIN users u ON o.user_id = u.id 
                LEFT JOIN service_men s ON o.service_man_id = s.id 
                ORDER BY o.created_at DESC";
        $stmt = $pdo->query($sql);
        while ($row = $stmt->fetch()):
        ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['user_name']) ?></td>
            <td><?= $row['order_status'] ?></td>
            <td><?= htmlspecialchars($row['service_man_name'] ?? 'Not Assigned') ?></td>
            <td>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#assignModal<?= $row['id'] ?>">Assign Task</button>
                
                <!-- Modal -->
                <div class="modal fade" id="assignModal<?= $row['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST">
                                <div class="modal-header"><h5 class="modal-title">Assign Service Man</h5></div>
                                <div class="modal-body">
                                    <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                                    <label>Select Service Man:</label>
                                    <select name="service_man_id" class="form-select" required>
                                        <option value="">Select</option>
                                        <?php foreach($service_men as $sm): ?>
                                            <option value="<?= $sm['id'] ?>" <?= ($row['service_man_id'] == $sm['id']) ? 'selected' : '' ?>>
                                                <?= $sm['name'] ?> (<?= $sm['phone'] ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="assign_task" class="btn btn-primary">Assign</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include '../admin/includes/footer.php'; ?>
