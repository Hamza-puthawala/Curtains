<?php include 'includes/header.php'; ?>

<h2>Products <a href="product_form.php" class="btn btn-success float-end">Add Product</a></h2>
<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC";
        $stmt = $pdo->query($sql);
        while ($row = $stmt->fetch()):
        ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td>
                <?php if($row['image']): ?>
                    <img src="../uploads/products/<?= htmlspecialchars($row['image']) ?>" width="50">
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['category_name'] ?? 'Uncategorized') ?></td>
            <td><?= inr($row['price']) ?></td>
            <td><?= $row['stock'] ?></td>
            <td>
                <a href="product_form.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="product_delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include 'includes/footer.php'; ?>
