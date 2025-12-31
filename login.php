<?php
session_start();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $error = "من فضلك أدخل البريد وكلمة المرور";
    } else {

        if (!file_exists("users.json")) {
            $error = "ملف المستخدمين غير موجود";
        } else {

            $users = json_decode(file_get_contents("users.json"), true);
            $found = false;

            foreach ($users as $user) {
                if (
                    isset($user['email'], $user['password'], $user['role']) &&
                    $user['email'] === $email &&
                    $user['password'] === $password
                ) {
                    // تسجيل الدخول
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['username'] = $user['name'];
                    $_SESSION['role'] = $user['role'];

                    // تحويل حسب الدور
                    if ($user['role'] === 'admin') {
                        header("Location: admin.php");
                    } elseif ($user['role'] === 'teacher') {
                        header("Location: teacher.php");
                    } else {
                        header("Location: student.php");
                    }
                    exit;
                }
            }

            $error = "❌ البريد الإلكتروني أو كلمة المرور غير صحيحة";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>تسجيل الدخول</title>
<style>
body{
    direction:rtl;
    font-family:Arial;
    background:#f2f2f2;
}
.box{
    background:#fff;
    width:350px;
    margin:100px auto;
    padding:25px;
    border-radius:10px;
    box-shadow:0 0 10px #ccc;
}
input,button{
    width:100%;
    padding:10px;
    margin:10px 0;
}
button{
    background:#00796b;
    color:#fff;
    border:none;
    cursor:pointer;
}
.error{
    color:red;
    text-align:center;
}
</style>
</head>

<body>
<div class="box">
<h2>🔐 تسجيل الدخول</h2>

<?php if($error): ?>
<p class="error"><?php echo $error; ?></p>
<?php endif; ?>

<form method="post">
    <input type="email" name="email" placeholder="البريد الإلكتروني" required>
    <input type="password" name="password" placeholder="كلمة المرور" required>
    <button>دخول</button>
</form>
</div>
</body>
</html>