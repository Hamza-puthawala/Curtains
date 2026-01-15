<?php include 'includes/header.php'; ?>

<h2>Dashboard</h2>
<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Total Orders</div>
            <div class="card-body">
                <h5 class="card-title">
                    <?php echo $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn(); ?>
                </h5>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">Total Sales</div>
            <div class="card-body">
                <h5 class="card-title">
                    <?php 
                        $sum = $pdo->query("SELECT SUM(total_amount) FROM orders WHERE payment_status='Paid'")->fetchColumn() ?: 0;
                        echo inr($sum);
                    ?>
                </h5>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-header">Total Products</div>
            <div class="card-body">
                <h5 class="card-title">
                    <?php echo $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn(); ?>
                </h5>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-header">Total Users</div>
            <div class="card-body">
                <h5 class="card-title">
                    <?php echo $pdo->query("SELECT COUNT(*) FROM users WHERE role='user'")->fetchColumn(); ?>
                </h5>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
