<?php 
require_once '../includes/config.php';
require_once '../includes/functions.php';

if(!isloggedIn() || !isAdmin()) {
    redirect('../login.php');
}

$orders = $pdo->query("SELECT * FROM orders ORDER BY id DESC");                 

include '../includes/header.php';
?>

<h2>ادارة الطلبات<h2>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>المستخدم</th>
            <th>التاريخ</th>
            <th>الحالة</th>
            <th>المجموع</th>
            <th>الاجراءات</th>
        </tr>   
    </thead>     
    <tbody>
        <?php if($orders && $orders->rowCount() > 0): ?>
           <?php while($order = $orders-> fetch()): ?>
           <tr>
               <td><?php echo $order ['id']; ?></td>
               <td><?php echo $order['user_id']; ?></td>
               <td><?php echo $order['order_date']; ?></td>
               <td><?php echo $order['status']; ?></td>
               <td><?php echo formatPrice($order['total']); ?></td>
               <td>
                   <a href="view_order.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-info">عرض</a>
                   <a href="delete_order.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل انت متاكد؟')">حذف</a>
               </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">لا توجد طلبات حتى الان</td>
            </tr>    
        <?php endif; ?>    
    </tbody>
</table>  

<?php include '../includes/footer.php'; ?>