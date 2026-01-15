<?php 
include 'includes/header.php'; 

$product = null;
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'] ?: null;
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image = $product['image'] ?? null;

    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../uploads/products/";
        $filename = time() . "_" . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $filename)) {
            $image = $filename;
        }
    }

    if ($product) {
        $sql = "UPDATE products SET category_id=?, name=?, description=?, price=?, stock=?, image=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$category_id, $name, $description, $price, $stock, $image, $product['id']]);
        setFlash('success', 'Product updated.');
    } else {
        $sql = "INSERT INTO products (category_id, name, description, price, stock, image) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$category_id, $name, $description, $price, $stock, $image]);
        setFlash('success', 'Product created.');
    }
    redirect('products.php');
}

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
?>

<h2><?= $product ? 'Edit' : 'Add' ?> Product</h2>
<form method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?= $product['name'] ?? '' ?>" required>
        </div>
        <div class="col-md-6 mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control">
                <option value="">Select Category</option>
                <?php foreach($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= ($product && $product['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                        <?= $cat['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-12 mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"><?= $product['description'] ?? '' ?></textarea>
        </div>
        <div class="col-md-6 mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?= $product['price'] ?? '' ?>" required>
        </div>
        <div class="col-md-6 mb-3">
            <label>Stock</label>
            <input type="number" name="stock" class="form-control" value="<?= $product['stock'] ?? '' ?>" required>
        </div>
        <div class="col-md-6 mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
            <?php if($product && $product['image']): ?>
                <img src="../uploads/products/<?= $product['image'] ?>" width="100" class="mt-2">
            <?php endif; ?>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="products.php" class="btn btn-secondary">Cancel</a>
</form>

<?php include '../admin/includes/footer.php'; ?>
