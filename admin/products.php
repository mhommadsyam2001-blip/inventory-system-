<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

if(!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
}

$products = $pdo->query("SELECT p.*, c.name as category_name 
                         FROM products p 
                         LEFT JOIN categories c ON p.category_id = c.id 
                         ORDER BY p.id DESC")->fetchAll();

include '../includes/header.php';
?>

<h2>إدارة المنتجات</h2>
<a href="add_product.php" class="btn btn-primary mb-3">➕ إضافة منتج جديد</a>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>الصورة</th>
            <th>الاسم</th>
            <th>السعر</th>
            <th>الكمية</th>
            <th>التصنيف</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($products as $product): ?>
        <tr>
            <td><?php echo $product['id']; ?></td>
            <td>
                <?php if($product['image']): ?>
                    <img src="/database/assests/uploads/<?php echo $product['image']; ?>" width="50">
                <?php else: ?>
                    <span class="text-muted">لا توجد</span>
                <?php endif; ?>
            </td>
            <td><?php echo htmlspecialchars($product['name']); ?></td>
            <td><?php echo formatPrice($product['price']); ?></td>
            <td><?php echo $product['quantity']; ?></td>
            <td><?php echo htmlspecialchars($product['category_name'] ?? 'غير مصنف'); ?></td>
            <td>
                <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-warning">تعديل</a>
                <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد؟')">حذف</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>

