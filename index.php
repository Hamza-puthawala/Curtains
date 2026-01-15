<?php
require_once 'includes/functions.php';
include 'includes/header.php';
?>

<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Welcome to ShopSystem</h1>
        <p class="col-md-8 fs-4">Your one-stop shop for everything. Quality products at the best prices.</p>
        <a class="btn btn-primary btn-lg" href="products.php" role="button">Shop Now</a>
    </div>
</div>

<h2 class="mb-4">Featured Products</h2>
<div class="row">
    <?php
    $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 4");
    while ($product = $stmt->fetch()):
    ?>
    <div class="col-md-3 mb-4">
        <div class="card h-100">
            <?php if($product['image']): ?>
                <img src="uploads/products/<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" style="height: 200px; object-fit: cover;">
            <?php else: ?>
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">No Image</div>
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                <p class="card-text"><?= inr($product['price']) ?></p>
                <a href="product_details.php?id=<?= $product['id'] ?>" class="btn btn-outline-primary">View Details</a>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<?php include 'includes/footer.php'; ?>
