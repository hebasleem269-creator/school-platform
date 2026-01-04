<?php
session_start();

// حماية الصفحة: بس الأدمن
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$users = file_exists("users.json") ? json_decode(file_get_contents("users.json"), true) : [];
$edit_user = null;

// جلب بيانات المستخدم المراد تعديله
if (isset($_GET['email'])) {
    $email = $_GET['email'];
    foreach ($users as $u) {
        if ($u['email'] === $email) {
            $edit_user = $u;
            break;
        }
    }
}

// معالجة الفورم
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($users as &$u) {
        if ($u['email'] === $_POST['original_email']) {
            $u['username'] = $_POST['username'];
            $u['email'] = $_POST['email'];
            $u['role'] = $_POST['role'];

            // تحديث الصورة إذا رفعت
            if (!empty($_FILES['image']['name'])) {
                $file_name = time() . "_" . $_FILES['image']['name'];
                $profile_pic = "uploads/" . $file_name;
                move_uploaded_file($_FILES['image']['tmp_name'], $profile_pic);
                $u['profile_pic'] = $profile_pic;
            }
            break;
        }
    }
    file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    header("Location: admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>تعديل مستخدم</title>
<style>
body{direction: rtl; font-family: Tahoma, Arial; background:#f2f4f7; margin:0; padding:0;}
.container{width:400px; background:#fff; margin:60px auto; padding:25px; border-radius:10px; box-shadow:0 0 15px rgba(0,0,0,0.1);}
label{display:block; margin-bottom:6px; color:#555; font-weight:bold;}
input, select{width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius:6px; font-size:14px;}
button{width:100%; padding:12px; background:#007bff; color:#fff; border:none; border-radius:6px; font-size:16px; cursor:pointer;}
button:hover{background:#0056b3;}
img{display:block; margin:10px auto; border-radius:50%; width:120px;}
</style>
</head>
<body dir="rtl">
<div class="container">
    <h1>تعديل بيانات المستخدم</h1>
    <?php if($edit_user): ?>
    <?php if(!empty($edit_user['profile_pic'])): ?>
        <img src="<?php echo $edit_user['profile_pic']; ?>" alt="صورة المستخدم">
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="original_email" value="<?php echo $edit_user['email']; ?>">
        
        <label>الاسم</label>
        <input type="text" name="username" value="<?php echo $edit_user['username']; ?>" required>
        
        <label>البريد الإلكتروني</label>
        <input type="email" name="email" value="<?php echo $edit_user['email']; ?>" required>
        
        <label>الدور</label>
        <select name="role" required>
            <option value="student" <?php if($edit_user['role']=='student') echo 'selected'; ?>>طالب</option>
            <option value="teacher" <?php if($edit_user['role']=='teacher') echo 'selected'; ?>>مدرس</option>
            <option value="admin" <?php if($edit_user['role']=='admin') echo 'selected'; ?>>أدمن</option>
        </select>
        
        <label>تغيير الصورة الشخصية</label>
        <input type="file" name="image" accept="image/*">
        
        <button type="submit">حفظ التعديلات</button>
    </form>
    <?php else: ?>
        <p>المستخدم غير موجود.</p>
    <?php endif; ?>
</div>
</body>
</html>