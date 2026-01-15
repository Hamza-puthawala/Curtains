<?php require_once __DIR__ . '/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { min-height: 100vh; display: flex; flex-direction: column; }
        footer { margin-top: auto; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/unit1/index.php">ShopSystem</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="/unit1/index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/unit1/products.php">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="/unit1/services.php">Services</a></li>
        <li class="nav-item"><a class="nav-link" href="/unit1/about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="/unit1/inquiry.php">Inquiry</a></li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="/unit1/cart.php"><i class="fas fa-shopping-cart"></i> Cart</a></li>
        <?php if(isset($_SESSION['user_id'])): ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <?= htmlspecialchars($_SESSION['user_name']) ?>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/unit1/orders.php">My Orders</a></li>
                    <li><a class="dropdown-item" href="/unit1/track_order.php">Track Order</a></li>
                    <?php if($_SESSION['role'] === 'admin'): ?>
                        <li><a class="dropdown-item" href="/unit1/admin/dashboard.php">Admin Panel</a></li>
                    <?php elseif($_SESSION['role'] === 'employee'): ?>
                        <li><a class="dropdown-item" href="/unit1/employee/dashboard.php">Employee Panel</a></li>
                    <?php endif; ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/unit1/logout.php">Logout</a></li>
                </ul>
            </li>
        <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="/unit1/login.php">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="/unit1/register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
<?php 
    if(function_exists('getFlash')) {
        $flash = getFlash();
        if($flash) echo "<div class='alert alert-{$flash['type']}'>{$flash['message']}</div>";
    }
?>
