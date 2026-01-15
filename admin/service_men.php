<?php 
include 'includes/header.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $name = trim($_POST['name']);
        $phone = trim($_POST['phone']);
        $pdo->prepare("INSERT INTO service_men (name, phone) VALUES (?, ?)")->execute([$name, $phone]);
        setFlash('success', 'Service Man added.');
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $pdo->prepare("DELETE FROM service_men WHERE id = ?")->execute([$id]);
        setFlash('success', 'Deleted.');
    }
}
?>
<h2>Service Men</h2>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Add Service Man</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3"><label>Name</label><input type="text" name="name" class="form-control" required></div>
                    <div class="mb-3"><label>Phone</label><input type="text" name="phone" class="form-control" required></div>
                    <button type="submit" name="add" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <table class="table table-bordered">
            <thead><tr><th>ID</th><th>Name</th><th>Phone</th><th>Action</th></tr></thead>
            <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM service_men");
                while ($row = $stmt->fetch()):
                ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td>
                        <form method="POST" onsubmit="return confirm('Delete?');">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
