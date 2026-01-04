<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['role']!='admin'){
    header("Location: login.php");
    exit;
}

// تحميل المستخدمين
$users = file_exists("users.json") ? json_decode(file_get_contents("users.json"), true) : [];

// معالجة إضافة مستخدم جديد
$message = '';
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['add_user'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];
    
    // تحقق من البريد الفريد
    $exists = false;
    foreach($users as $u){
        if($u['email']==$email){
            $exists = true;
            break;
        }
    }

    if(!$exists){
        // معالجة الصورة إذا تم رفعها
        $image_name = '';
        if(isset($_FILES['image']) && $_FILES['image']['name']!=''){
            $image_name = time().'_'.basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$image_name);
        }

        $users[] = [
            "name"=>$name,
            "email"=>$email,
            "password"=>$password,
            "role"=>$role,
            "image"=>$image_name
        ];
        file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT));
        $message = "✅ تم إضافة المستخدم بنجاح!";
    } else {
        $message = "⚠️ هذا البريد مستخدم مسبقاً!";
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>صفحة الأدمن</title>
<style>
body{font-family:Arial; direction:rtl; background:#f2f2f2; margin:0; padding:0;}
.container{max-width:1000px; margin:20px auto; padding:20px; background:#fff; border-radius:10px;}
h2{color:#006064; text-align:center;}
table{width:100%; border-collapse:collapse; margin-top:20px;}
table, th, td{border:1px solid #ccc;}
th, td{padding:10px; text-align:center;}
th{background:#00838f; color:#fff;}
tr:nth-child(even){background:#f2f2f2;}
form input, form select{padding:8px; margin:5px 0; width:100%; box-sizing:border-box;}
form button{background:#00838f; color:#fff; border:none; padding:10px 15px; border-radius:6px; cursor:pointer; margin-top:10px;}
form button:hover{background:#006064;}
.message{margin:10px 0; color:green; font-weight:bold;}
</style>
</head>
<body dir="rtl">
<div class="container">
<h2>أهلاً <?php echo $_SESSION['username']; ?> (الأدمن)</h2>
<a href="logout.php">🚪 تسجيل الخروج</a>

<?php if($message!=''){ echo "<p class='message'>{$message}</p>"; } ?>

<h3>المستخدمون الحاليون</h3>
<table>
<tr>
<th>الصورة</th>
<th>الاسم</th>
<th>البريد</th>
<th>الدور</th>
<th>تعديل</th>
<th>حذف</th>
</tr>
<?php foreach($users as $u): ?>
<tr>
<td>
<?php if($u['image']!=''): ?>
<img src="uploads/<?php echo $u['image']; ?>" alt="صورة" width="50">
<?php else: ?>
-
<?php endif; ?>
</td>
<td><?php echo $u['name']; ?></td>
<td><?php echo $u['email']; ?></td>
<td><?php echo $u['role']; ?></td>
<td><a href="edit_user.php?email=<?php echo $u['email']; ?>">تعديل</a></td>
<td><a href="delete_user.php?email=<?php echo $u['email']; ?>">حذف</a></td>
</tr>
<?php endforeach; ?>
</table>

<h3>إضافة مستخدم جديد</h3>
<form action="" method="post" enctype="multipart/form-data">
<input type="text" name="name" placeholder="الاسم" required>
<input type="email" name="email" placeholder="البريد الإلكتروني" required>
<input type="password" name="password" placeholder="كلمة المرور" required>
<select name="role" required>
<option value="">-- اختر الدور --</option>
<option value="teacher">teacher</option>
<option value="student">student</option>
<option value="admin">admin</option>
</select>
<input type="file" name="image">
<button type="submit" name="add_user">إضافة المستخدم</button>
</form>
</div>
</body>
</html>