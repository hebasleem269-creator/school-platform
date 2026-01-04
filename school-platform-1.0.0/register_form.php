<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>تسجيل حساب جديد</title>
</head>
<body dir="rtl">
  <h2>تسجيل حساب جديد</h2>
  <form method="post" action="register.php" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="الاسم" required><br><br>
    <input type="email" name="email" placeholder="البريد الإلكتروني" required><br><br>
    <input type="password" name="password" placeholder="كلمة المرور" required><br>
    <input type="text" name="school" placeholder="المدرسة"><br><br>
    <input type="text" name="class" placeholder="الصف"><br><br>
    <select name="role">
      <option value="student">طالب</option>
      <option value="teacher">مدرس</option>
    </select><br><br>
    <input type="file" name="profile"><br>
    <button type="submit">تسجيل</button>
  </form>
</body>
</html>