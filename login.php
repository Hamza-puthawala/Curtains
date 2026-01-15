<?php
require_once 'includes/functions.php';

if (isLoggedIn()) {
    redirect('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        
        setFlash('success', 'Welcome back, ' . $user['name']);
        
        if ($user['role'] === 'admin') {
            redirect('admin/dashboard.php');
        } elseif ($user['role'] === 'employee') {
            redirect('employee/dashboard.php');
        } else {
            redirect('index.php');
        }
    } else {
        setFlash('danger', 'Invalid email or password.');
    }
}

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Login</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
