
<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

if(!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
}

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    
    if(empty($name)) {
        $error = 'الرجاء إدخال اسم التصنيف';
    } else {
        $stmt = $pdo->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
        if($stmt->execute([$name, $description])) {
            $success = 'تم إضافة التصنيف بنجاح';
        } else {
            $error = 'حدث خطأ، حاول مرة أخرى';
        }
    }
}

include '../includes/header.php';
?>

<h2>إضافة تصنيف جديد</h2>

<div class="row">
    <div class="col-md-6">
        <?php if($error): echo showMessage($error); endif; ?>
        <?php if($success): echo showMessage($success, 'success'); endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label>اسم التصنيف *</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>الوصف</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">حفظ التصنيف</button>
            <a href="categories.php" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

