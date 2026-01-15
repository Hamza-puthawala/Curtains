<?php include 'includes/header.php'; 

if(isset($_POST['update_cart'])) {
    foreach($_POST['qty'] as $pid => $qty) {
        if($qty <= 0) unset($_SESSION['cart'][$pid]);
        else $_SESSION['cart'][$pid] = $qty;
    }
    setFlash('success', 'Cart updated.');
}
if(isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    redirect('cart.php');
}

$cart = $_SESSION['cart'] ?? [];
$products = [];
if($cart) {
    $ids = implode(',', array_keys($cart));
    $products = $pdo->query("SELECT * FROM products WHERE id IN ($ids)")->fetchAll();
}
?>

<h2>Shopping Cart</h2>
<?php if(empty($products)): ?>
    <p>Your cart is empty.</p>
<?php else: ?>
    <form method="POST">
        <table class="table">
            <thead><tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th><th>Action</th></tr></thead>
            <tbody>
                <?php 
                $total = 0;
                foreach($products as $p): 
                    $qty = $cart[$p['id']];
                    $subtotal = $p['price'] * $qty;
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td><?= inr($p['price']) ?></td>
                    <td><input type="number" name="qty[<?= $p['id'] ?>]" value="<?= $qty ?>" min="1" class="form-control" style="width: 80px;"></td>
                    <td><?= inr($subtotal) ?></td>
                    <td><a href="cart.php?remove=<?= $p['id'] ?>" class="btn btn-danger btn-sm">Remove</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td><strong><?= inr($total) ?></strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <button type="submit" name="update_cart" class="btn btn-secondary">Update Cart</button>
        <a href="checkout.php" class="btn btn-primary">Checkout</a>
    </form>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
