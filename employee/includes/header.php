<?php
require_once __DIR__ . '/../../includes/functions.php';
if (!isEmployee()) {
    setFlash('danger', 'Access denied.');
    redirect('../login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar { height: 100vh; position: fixed; top: 0; left: 0; width: 250px; background: #343a40; padding-top: 20px; }
        .sidebar a { color: white; padding: 15px; display: block; text-decoration: none; }
        .sidebar a:hover { background: #495057; }
        .content { margin-left: 250px; padding: 20px; }
        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .content { margin-left: 0; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h3 class="text-center text-white">Employee Panel</h3>
    <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="products.php"><i class="fas fa-box"></i> Products</a>
    <a href="orders.php"><i class="fas fa-tasks"></i> Assign Tasks (Orders)</a>
    <a href="service_men.php"><i class="fas fa-truck"></i> Service Men</a>
    <a href="inquiries.php"><i class="fas fa-envelope"></i> Inquiries</a>
    <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="content">
    <?php 
    if(function_exists('getFlash')) {
        $flash = getFlash();
        if($flash) echo "<div class='alert alert-{$flash['type']}'>{$flash['message']}</div>";
    }
    ?>
