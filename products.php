<?php include 'includes/header.php'; ?>
<h2>Products</h2>
<!-- Search form -->
<form class="mb-4" method="GET">
    <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search products..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
        <button class="btn btn-outline-secondary" type="submit">Search</button>
    </div>
</form>

<div class="row">
    <?php
    $search = $_GET['q'] ?? '';
    $sql = "SELECT * FROM products WHERE name LIKE ? OR description LIKE ?";
    $params = ["%$search%", "%$search%"];
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    
    while ($product = $stmt->fetch()):
    ?>
    <div class="col-md-3 mb-4">
        <div class="card h-100">
             <?php if($product['image']): ?>
                <img src="uploads/products/<?= htmlspecialchars($product['image']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
            <?php else: ?>
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">No Image</div>
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                <p class="card-text"><?= inr($product['price']) ?></p>
                <a href="product_details.php?id=<?= $product['id'] ?>" class="btn btn-primary">View</a>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>
<?php include 'includes/footer.php'; ?>
