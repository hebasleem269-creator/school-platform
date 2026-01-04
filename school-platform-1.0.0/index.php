<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>الصفحة الرئيسية</title>
<style>
/* --- عام --- */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(to right, #74ebd5, #ACB6E5);
    margin: 0;
    padding: 0;
    direction: rtl;
}

/* --- Navbar أعلى الصفحة --- */
.navbar {
    width: 100%;
    background-color: rgba(255, 255, 255, 0.9);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 40px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
}
.navbar .left, .navbar .right {
    display: flex;
    align-items: center;
}
.navbar a {
    text-decoration: none;
    padding: 8px 15px;
    margin: 0 5px;
    border-radius: 5px;
    color: white;
    font-weight: bold;
    transition: 0.3s;
}
a.login { background-color: #4CAF50; }
a.login:hover { background-color: #45a049; }
a.register { background-color: #2196F3; }
a.register:hover { background-color: #1976D2; }
a.profile { background-color: #FF9800; }
a.profile:hover { background-color: #FB8C00; }
a.logout { background-color: #f44336; }
a.logout:hover { background-color: #d32f2f; }
img.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    margin-left: 10px;
    border: 2px solid #4CAF50;
}

/* --- محتوى الصفحة --- */
.container {
    margin-top: 120px;
    text-align: center;
}
h1 {
    font-size: 32px;
    color: #fff;
}
p {
    font-size: 18px;
    color: #eee;
}
</style>
</head>
<body dir="rtl">

<div class="navbar">
    <div class="left">
        <a href="index.php">🏠 الرئيسية</a>
        <?php if(isset($_SESSION['username'])): ?>
            <?php if($_SESSION['role'] === 'student'): ?>
                <a href="student.php">📚 الطالب</a>
            <?php elseif($_SESSION['role'] === 'teacher'): ?>
                <a href="teacher.php">👨‍🏫 المدرس</a>
            <?php elseif($_SESSION['role'] === 'admin'): ?>
                <a href="admin.php">⚙️ الأدمن</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="right">
        <?php if(isset($_SESSION['username'])): ?>
            <?php if(!empty($_SESSION['profile_pic']) && file_exists($_SESSION['profile_pic'])): ?>
                <img src="<?php echo htmlspecialchars($_SESSION['profile_pic']); ?>" class="avatar" alt="Avatar">
            <?php endif; ?>
            <a href="profile.php" class="profile"><?php echo htmlspecialchars($_SESSION['username']); ?></a>
            <a href="logout.php" class="logout">🚪 تسجيل الخروج</a>
        <?php else: ?>
            <a href="login.php" class="login">تسجيل الدخول</a>
            <a href="register.php" class="register">تسجيل حساب جديد</a>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <h1>مرحباً بك في موقعنا</h1>
    <?php if(isset($_SESSION['username'])): ?>
        <p>دورك: <strong><?php echo htmlspecialchars($_SESSION['role']); ?></strong></p>
        <p>يمكنك الوصول إلى صفحاتك من الروابط أعلاه.</p>
    <?php else: ?>
        <p>ابدأ الآن بتسجيل الدخول أو إنشاء حساب جديد للتمتع بجميع المزايا.</p>
    <?php endif; ?>
</div>

</body>
</html>