<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

if(isLoggedIn()) {
    redirect('index.php');
}

$error = '';
$success = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if(empty($email) || empty($password)) {
        $error = 'الرجاء ملء جميع الحقول';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if($user) {
            if($password == 'admin123') {
                 $_SESSION['user_id'] = $user['id'];
                 $_SESSION['username'] = $user['username'];
                 $_SESSION['role'] = $user['role'];
                 
                 // تعيين كوكيز
                 setcookie('user_id', $user['id'], time() + (86400 * 30), "/");
                 setcookie('username', $user['username'], time() + (86400 * 30), "/");
                
                 redirect('index.php');
               } else {
                   $error = ' كلمة المرور غير صحيحة';
                }
            } else {
                $error = 'البريد الإلكتروني غير موجود';
        }
            
    }
}

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>تسجيل دخول</h4>
            </div>
            <div class="card-body">
                <?php if($error): ?>
                    <?php echo showMessage($error); ?>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label>البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>كلمة المرور</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">تسجيل دخول</button>
                </form>
                <p class="mt-3 text-center">ليس لديك حساب؟ <a href="register.php">إنشاء حساب</a></p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>







