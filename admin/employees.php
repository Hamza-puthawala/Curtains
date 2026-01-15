<?php 
include 'includes/header.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = 'employee';
        
        // Check email
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if($stmt->fetch()) {
            setFlash('danger', 'Email exists.');
        } else {
            $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)")->execute([$name, $email, $password, $role]);
            setFlash('success', 'Employee added.');
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $pdo->prepare("DELETE FROM users WHERE id = ? AND role='employee'")->execute([$id]);
        setFlash('success', 'Deleted.');
    }
}
?>
<h2>Employees</h2>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Add Employee</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3"><label>Name</label><input type="text" name="name" class="form-control" required></div>
                    <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
                    <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
                    <button type="submit" name="add" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <table class="table table-bordered">
            <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Action</th></tr></thead>
            <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM users WHERE role='employee'");
                while ($row = $stmt->fetch()):
                ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
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
