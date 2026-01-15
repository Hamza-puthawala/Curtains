<?php 
include 'includes/header.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_category'])) {
        $name = trim($_POST['name']);
        if ($name) {
            $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
            $stmt->execute([$name]);
            setFlash('success', 'Category added.');
        }
    } elseif (isset($_POST['delete_category'])) {
        $id = $_POST['id'];
        $pdo->prepare("DELETE FROM categories WHERE id = ?")->execute([$id]);
        setFlash('success', 'Category deleted.');
    }
}
?>

<h2>Categories</h2>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Add Category</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <button type="submit" name="add_category" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <table class="table table-bordered">
            <thead><tr><th>ID</th><th>Name</th><th>Action</th></tr></thead>
            <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM categories");
                while ($row = $stmt->fetch()):
                ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td>
                        <form method="POST" onsubmit="return confirm('Are you sure?');">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" name="delete_category" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
