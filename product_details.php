<?php include 'includes/header.php'; 
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if(!$product) {
    echo "Product not found.";
    include 'includes/footer.php';
    exit;
}

if(isset($_POST['add_to_cart'])) {
    if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    $qty = $_POST['quantity'];
    
    if(isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += $qty;
    } else {
        $_SESSION['cart'][$id] = $qty;
    }
    setFlash('success', 'Added to cart.');
    redirect('cart.php');
}
?>

<div class="row">
    <div class="col-md-6">
        <?php if($product['image']): ?>
            <img src="uploads/products/<?= htmlspecialchars($product['image']) ?>" class="img-fluid rounded">
        <?php else: ?>
            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 400px;">No Image</div>
        <?php endif; ?>
    </div>
    <div class="col-md-6">
        <h2><?= htmlspecialchars($product['name']) ?></h2>
        <h3 class="text-primary"><?= inr($product['price']) ?></h3>
        <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
        <p>Stock: <?= $product['stock'] ?></p>
        
        <?php if($product['stock'] > 0): ?>
        <form method="POST">
            <div class="mb-3 w-25">
                <label>Quantity</label>
                <input type="number" name="quantity" class="form-control" value="1" min="1" max="<?= $product['stock'] ?>">
            </div>
            <button type="submit" name="add_to_cart" class="btn btn-success btn-lg">Add to Cart</button>
        </form>
        <?php else: ?>
            <button class="btn btn-secondary btn-lg" disabled>Out of Stock</button>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
