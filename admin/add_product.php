<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

if(!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
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
    } elseif(!is_numeric($price) || $price <= 0) {
        $error = 'السعر يجب أن يكون رقماً موجباً';
    } elseif(!is_numeric($quantity) || $quantity < 0) {
        $error = 'الكمية يجب أن تكون رقماً غير سالب';
    } else {
        $image = null;
        if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = uploadImage($_FILES['image']);
        }
        
        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, quantity, category_id, image) 
                               VALUES (?, ?, ?, ?, ?, ?)");
        if($stmt->execute([$name, $description, $price, $quantity, $category_id, $image])) {
            $success = 'تم إضافة المنتج بنجاح';
        } else {
            $error = 'حدث خطأ، حاول مرة أخرى';
        }
    }
}

include '../includes/header.php';
?>

<h2>إضافة منتج جديد</h2>

<div class="row">
    <div class="col-md-8">
        <?php if($error): echo showMessage($error); endif; ?>
        <?php if($success): echo showMessage($success, 'success'); endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>اسم المنتج *</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>الوصف</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label>السعر *</label>
                <input type="number" name="price" class="form-control" step="0.01" required>
            </div>
            <div class="mb-3">
                <label>الكمية *</label>
                <input type="number" name="quantity" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>التصنيف</label>
                <select name="category_id" class="form-control">
                    <option value="">بدون تصنيف</option>
                    <?php foreach($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>">
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>الصورة</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">حفظ المنتج</button>
            <a href="products.php" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>


