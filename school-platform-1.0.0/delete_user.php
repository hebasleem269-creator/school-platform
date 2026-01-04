<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

// التحقق من وجود البريد في الرابط
if(!isset($_GET['email'])){
    header("Location: admin.php");
    exit;
}

$email = $_GET['email'];

// قراءة المستخدمين من JSON
$users = file_exists("users.json") ? json_decode(file_get_contents("users.json"), true) : [];

// فلترة المستخدمين لإزالة المستخدم المطلوب
$users = array_filter($users, function($u) use ($email){
    return $u['email'] !== $email;
});

// إعادة ترقيم المصفوفة
$users = array_values($users);

// حفظ التغييرات في JSON
file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT));

// الرجوع لصفحة الأدمن بعد الحذف
header("Location: admin.php");
exit;
?>