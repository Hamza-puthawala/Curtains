<?php include 'includes/header.php'; ?>
<h2>Users</h2>
<table class="table table-bordered">
    <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Joined</th></tr></thead>
    <tbody>
        <?php
        $stmt = $pdo->query("SELECT * FROM users WHERE role='user'");
        while ($row = $stmt->fetch()):
        ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include 'includes/footer.php'; ?>
