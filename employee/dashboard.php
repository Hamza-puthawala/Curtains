<?php include 'includes/header.php'; ?>
<h2>Employee Dashboard</h2>
<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Pending Orders</div>
            <div class="card-body">
                <h5 class="card-title">
                    <?php echo $pdo->query("SELECT COUNT(*) FROM orders WHERE order_status='Pending'")->fetchColumn(); ?>
                </h5>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
            <div class="card-header">Inquiries</div>
            <div class="card-body">
                <h5 class="card-title">
                    <?php echo $pdo->query("SELECT COUNT(*) FROM inquiries")->fetchColumn(); ?>
                </h5>
            </div>
        </div>
    </div>
</div>
<?php include '../admin/includes/footer.php'; ?>
