
<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

if(!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
}

$categories = $pdo->query("SELECT * FROM categories ORDER BY id DESC")->fetchAll();

include '../includes/header.php';
?>

<h2>إدارة التصنيفات</h2>
<a href="add_category.php" class="btn btn-primary mb-3">➕ إضافة تصنيف جديد</a>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>الاسم</th>
            <th>الوصف</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($categories as $category): ?>
        <tr>
            <td><?php echo $category['id']; ?></td>
            <td><?php echo htmlspecialchars($category['name']); ?></td>
            <td><?php echo htmlspecialchars($category['description']); ?></td>
            <td>
                <a href="edit_category.php?id=<?php echo $category['id']; ?>" class="btn btn-sm btn-warning">تعديل</a>
                <a href="delete_category.php?id=<?php echo $category['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد؟')">حذف</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>


