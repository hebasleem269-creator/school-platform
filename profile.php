<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$role = $_SESSION['role'];
$profile_pic = $_SESSION['profile_pic'] ?? 'default_avatar.png';
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>الملف الشخصي</title>
<style>
body{
    font-family:Arial;
    background:#f0f2f5;
    margin:0;
    direction:rtl;
}
.container{
    max-width:500px;
    margin:60px auto;
    background:#fff;
    padding:30px;
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,0.2);
    text-align:center;
}
.avatar{
    width:120px;
    height:120px;
    border-radius:50%;
    object-fit:cover;
    margin-bottom:20px;
    border:3px solid #4CAF50;
}
.info{
    margin:15px 0;
    font-size:18px;
}
.role{
    display:inline-block;
    padding:6px 15px;
    border-radius:20px;
    background:#4CAF50;
    color:#fff;
    font-size:14px;
}
a.btn{
    display:inline-block;
    margin-top:20px;
    padding:10px 20px;
    background:#2196F3;
    color:white;
    border-radius:6px;
    text-decoration:none;
}
a.btn:hover{
    background:#1976D2;
}
.back{
    background:#777;
    margin-right:10px;
}
</style>
</head>
<body dir="rtl">

<div class="container">
    <img src="<?php echo $profile_pic; ?>" class="avatar" alt="صورة البروفايل">

    <div class="info"><strong>الاسم:</strong> <?php echo htmlspecialchars($username); ?></div>
    <div class="info"><strong>البريد:</strong> <?php echo htmlspecialchars($email); ?></div>
    <div class="info">
        <span class="role"><?php echo htmlspecialchars($role); ?></span>
    </div>

    <?php
    if($role === 'admin') $back = 'admin.php';
    elseif($role === 'teacher') $back = 'teacher.php';
    else $back = 'student.php';
    ?>

    <a href="<?php echo $back; ?>" class="btn back">الرجوع</a>
    <a href="logout.php" class="btn">تسجيل الخروج</a>
</div>

</body>
</html>