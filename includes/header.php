<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام إدارة المخزون</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/database/index.php">🏪 نظام المخزون</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if(isLoggedIn()): ?>
                    <li class="nav-item"><a class="nav-link" href="/database/index.php">الرئيسية</a></li>
                    <?php if(isAdmin()): ?>
                        <li class="nav-item"><a class="nav-link" href="/database/admin/dashboard.php">لوحة التحكم</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="/database/logout.php">تسجيل خروج</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/database/login.php">تسجيل دخول</a></li>
                    <li class="nav-item"><a class="nav-link" href="/database/register.php">إنشاء حساب</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-4">


