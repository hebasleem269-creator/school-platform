<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['name']; // الاسم من الفورم
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $role     = $_POST['role'];

    // إنشاء مجلد الصور لو مش موجود
    if (!is_dir("uploads")) {
        mkdir("uploads");
    }

    // رفع الصورة
    $profile_pic = "";
    if (!empty($_FILES['image']['name'])) { // اسم الحقل مطابق للفورم
        $file_name = time() . "_" . $_FILES['image']['name'];
        $profile_pic = "uploads/" . $file_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $profile_pic);
    }

    // قراءة المستخدمين من JSON أو إنشاء مصفوفة جديدة
    $users = file_exists("users.json") ? json_decode(file_get_contents("users.json"), true) : [];

    // إضافة المستخدم الجديد
    $users[] = [
        "username" => $username,
        "email" => $email,
        "password" => password_hash($password, PASSWORD_DEFAULT),
        "role" => $role,
        "profile_pic" => $profile_pic
    ];

    file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    // حفظ بيانات الجلسة
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['role'] = $role;
    $_SESSION['profile_pic'] = $profile_pic;

    // تحويل حسب الدور
    if ($role === "admin") header("Location: admin.php");
    elseif ($role === "teacher") header("Location: teacher.php");
    else header("Location: student.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>تسجيل حساب جديد</title>
<style>
body{direction: rtl; font-family: Tahoma, Arial; background: #f2f4f7; margin:0; padding:0;}
.container{width: 400px; background:#fff; margin:60px auto; padding:25px; border-radius:10px; box-shadow:0 0 15px rgba(0,0,0,0.1);}
h1{text-align:center; color:#333; margin-bottom:20px;}
label{display:block; margin-bottom:6px; color:#555; font-weight:bold;}
input[type="text"], input[type="email"], input[type="password"], input[type="file"], select{width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius:6px; font-size:14px; background:#fff;}
input:focus{outline:none; border-color:#007bff;}
button{width:100%; padding:12px; background:#007bff; color:#fff; border:none; border-radius:6px; font-size:16px; cursor:pointer;}
button:hover{background:#0056b3;}
.error{background:#f8d7da; color:#721c24; padding:10px; border-radius:5px; margin-bottom:15px; text-align:center;}
.success{background:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:15px; text-align:center;}
</style>
</head>
<body dir="rtl">

<div class="container">
    <h1>إنشاء حساب جديد</h1>

    <form method="post" enctype="multipart/form-data">
        <label>الاسم</label>
        <input type="text" name="name" required>

        <label>البريد الإلكتروني</label>
        <input type="email" name="email" required>

        <label>كلمة المرور</label>
        <input type="password" name="password" required>

        <label>الدور</label>
        <select name="role" required>
            <option value="">-- اختر الدور --</option>
            <option value="student">طالب</option>
            <option value="teacher">مدرس</option>
            <option value="admin">أدمن</option>
        </select>

        <label>الصورة الشخصية</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit">تسجيل</button>
    </form>
</div>

</body>
</html>