
<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

if(!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
}

// إحصائيات
$total_products = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$total_categories = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$total_users = $pdo->query("SELECT COUNT(*) FROM user")->fetchColumn();
$total_orders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();

include '../includes/header.php';
?>

<h2>لوحة التحكم</h2>
<hr>

<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">المنتجات</h5>
                <h1><?php echo $total_products; ?></h1>
                <a href="products.php" class="text-white">عرض الكل</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">التصنيفات</h5>
                <h1><?php echo $total_categories; ?></h1>
                <a href="categories.php" class="text-white">عرض الكل</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">المستخدمين</h5>
                <h1><?php echo $total_users; ?></h1>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">الطلبات</h5>
                <h1><?php echo $total_orders; ?></h1>
                <a href="orders.php" class="text-white">عرض الكل</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>إدارة سريعة</h5>
            </div>
            <div class="card-body">
                <a href="add_product.php" class="btn btn-primary">➕ إضافة منتج</a>
                <a href="add_category.php" class="btn btn-success">➕ إضافة تصنيف</a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

