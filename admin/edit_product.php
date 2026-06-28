
<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

if(!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
}

$id = $_GET['id'] ?? 0;
$product = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$product->execute([$id]);
$product = $product->fetch();

if(!$product) {
    redirect('products.php');
}

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $category_id = $_POST['category_id'];
    
    if(empty($name) || empty($price) || empty($quantity)) {
        $error = 'الرجاء ملء جميع الحقول المطلوبة';
    } else {
        $image = $product['image'];
        if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = uploadImage($_FILES['image']);
        }
        
        $stmt = $pdo->prepare("UPDATE products SET 
                               name = ?, description = ?, price = ?, quantity = ?, 
                               category_id = ?, image = ? WHERE id = ?");
        if($stmt->execute([$name, $description, $price, $quantity, $category_id, $image, $id])) {
            $success = 'تم تحديث المنتج بنجاح';
        } else {
            $error = 'حدث خطأ، حاول مرة أخرى';
        }
    }
}

include '../includes/header.php';
?>

<h2>تعديل المنتج</h2>

<div class="row">
    <div class="col-md-8">
        <?php if($error): echo showMessage($error); endif; ?>
        <?php if($success): echo showMessage($success, 'success'); endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>اسم المنتج *</label>
                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label>الوصف</label>
                <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label>السعر *</label>
                <input type="number" name="price" class="form-control" step="0.01" value="<?php echo $product['price']; ?>" required>
            </div>
            <div class="mb-3">
                <label>الكمية *</label>
                <input type="number" name="quantity" class="form-control" value="<?php echo $product['quantity']; ?>" required>
            </div>
            <div class="mb-3">
                <label>التصنيف</label>
                <select name="category_id" class="form-control">
                    <option value="">بدون تصنيف</option>
                    <?php foreach($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>" <?php echo $category['id'] == $product['category_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>الصورة الحالية</label>
                <?php if($product['image']): ?>
                    <img src="../assets/uploads/<?php echo $product['image']; ?>" width="100">
                <?php endif; ?>
                <input type="file" name="image" class="form-control mt-2" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">تحديث المنتج</button>
            <a href="products.php" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>



