<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
include 'includes/header.php';
?>

<div class="jumbotron bg-light p-5 rounded">
    <h1 class="display-4">مرحباً بك في نظام إدارة المخزون</h1>
    <p class="lead">نظام متكامل لإدارة المنتجات والمخزون والمبيعات</p>
    <hr class="my-4">
    <p>يمكنك إدارة المنتجات والتصنيفات ومتابعة الطلبات من خلال لوحة التحكم</p>
    <?php if(!isLoggedIn()): ?>
        <a class="btn btn-primary btn-lg" href="login.php">تسجيل دخول</a>
        <a class="btn btn-success btn-lg" href="register.php">إنشاء حساب</a>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>




