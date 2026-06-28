<?php
// التحقق من تسجيل الدخول
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// التحقق من صلاحية المسؤول
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
}

// إعادة التوجيه
function redirect($url) {
    header("Location: $url");
    exit();
}

// عرض رسائل الخطأ
function showMessage($msg, $type = 'danger') {
    return "<div class='alert alert-$type'>$msg</div>";
}

// رفع الصورة
function uploadImage($file, $targetDir = null) {
    if ($targetDir === null) {
        $targetDir = 'c:/xampp/htdocs/database/assests/uploads/';
    }
    
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $imageName = time() . '_' . basename($file['name']);
    $targetFile = $targetDir . $imageName;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        return $imageName;
    }
    return null;
}

// تنسيق السعر
function formatPrice($price) {
    return number_format($price, 2) . ' ₪';
}
?>

