
<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

if(isLoggedIn()) {
    redirect('index.php');
}

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if(empty($username) || empty($email) || empty($password)) {
        $error = 'الرجاء ملء جميع الحقول';
    } elseif($password != $confirm_password) {
        $error = 'كلمة المرور غير متطابقة';
    } elseif(strlen($password) < 6) {
        $error = 'كلمة المرور يجب أن تكون 6 أحرف على الأقل';
    } else {
        // التحقق من عدم وجود البريد الإلكتروني مسبقاً
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ? OR username = ?");
        $stmt->execute([$email, $username]);
        if($stmt->rowCount() > 0) {
            $error = 'البريد الإلكتروني أو اسم المستخدم موجود مسبقاً';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
            if($stmt->execute([$username, $email, $hashed])) {
                $success = 'تم إنشاء الحساب بنجاح. يمكنك الآن تسجيل الدخول';
            } else {
                $error = 'حدث خطأ، حاول مرة أخرى';
            }
        }
    }
}

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4>إنشاء حساب جديد</h4>
            </div>
            <div class="card-body">
                <?php if($error): ?>
                    <?php echo showMessage($error); ?>
                <?php endif; ?>
                <?php if($success): ?>
                    <?php echo showMessage($success, 'success'); ?>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label>اسم المستخدم</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>كلمة المرور</label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>
                    <div class="mb-3">
                        <label>تأكيد كلمة المرور</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">إنشاء حساب</button>
                </form>
                <p class="mt-3 text-center">لديك حساب؟ <a href="login.php">تسجيل دخول</a></p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>


