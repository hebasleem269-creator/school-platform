<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['role']!='teacher'){
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar">
<head
<link rel="stylesheet"herf="style.css">
<meta charset="UTF-8">
<title>صفحة المدرس</title>

<style>
body{
    direction: rtl;
    font-family: Arial, Tahoma;
    background: #f2f4f8;
    margin: 0;
    padding: 0;
}

.container{
    max-width: 900px;
    margin: 30px auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,.1);
}

h2{
    color:#333;
}

h3{
    background:#1e88e5;
    color:#fff;
    padding:10px;
    border-radius:6px;
}

a{
    color:#1e88e5;
    text-decoration:none;
    font-weight:bold;
}

a:hover{
    text-decoration:underline;
}

form{
    background:#fafafa;
    padding:15px;
    border-radius:8px;
    margin-bottom:20px;
}

input[type=text],
textarea,
input[type=file]{
    width:100%;
    padding:10px;
    margin-top:5px;
    margin-bottom:10px;
    border:1px solid #ccc;
    border-radius:6px;
}

textarea{
    resize:vertical;
    min-height:80px;
}

button{
    background:#1e88e5;
    color:#fff;
    border:none;
    padding:10px 20px;
    border-radius:6px;
    cursor:pointer;
    font-size:16px;
}

button:hover{
    background:#1565c0;
}

.card{
    border:1px solid #ddd;
    padding:15px;
    margin:10px 0;
    border-radius:8px;
    background:#fff;
}

.logout{
    float:left;
    background:#e53935;
    color:#fff;
    padding:8px 15px;
    border-radius:6px;
}

.logout:hover{
    background:#c62828;
}
.top-actions{
    display:flex;
    gap:10px;
    margin-bottom:20px;
}

.btn{
    display:inline-block;
    padding:10px 15px;
    border-radius:6px;
    font-weight:bold;
    color:#fff;
}

.submissions{
    background:#43a047;
}

.submissions:hover{
    background:#2e7d32;
}

.logout{
    background:#e53935;
}

.logout:hover{
    background:#c62828;
}
</style>

</head>

<h2>أهلاً <?php echo $_SESSION['username']; ?> 👋</h2>
<a href="submissions_teacher.php">📥 تسليمات الطلاب</a>
<div class="top-actions">


<a href="logout.php">🚪 تسجيل الخروج</a>
</div>
<hr>

<h3>📚 إضافة درس</h3>
<form action="add_lesson.php" method="post" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="عنوان الدرس" required><br><br>
    <textarea name="desc" placeholder="شرح الدرس"></textarea><br><br>
    <input type="file" name="file" required><br><br>
    <button type="submit">إضافة الدرس</button>
</form>

<hr>

<h3>📝 إضافة واجب</h3>
<form action="add_assignment.php" method="post" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="عنوان الواجب" required><br><br>
    <textarea name="desc" placeholder="وصف الواجب"></textarea><br><br>
    <input type="file" name="file"><br><br>
    <button type="submit">إضافة الواجب</button>
</form>

<hr>

<h3>📖 دروسي</h3>
<?php
$lessons = file_exists("lessons.json")
    ? json_decode(file_get_contents("lessons.json"), true)
    : [];

foreach($lessons as $l){
    if($l['teacher']==$_SESSION['username']){
        echo "<div style='border:1px solid #ccc;padding:10px;margin:10px'>";
        echo "<b>{$l['title']}</b><br>";
        echo "{$l['desc']}<br>";
        echo "<a href='{$l['file']}'>📄 تحميل</a>";
        echo "</div>";
    }
}
?>

<hr>

<h3>📌 واجباتي</h3>
<?php
$assignments = file_exists("assignments.json")
    ? json_decode(file_get_contents("assignments.json"), true)
    : [];

foreach($assignments as $a){
    if($a['teacher']==$_SESSION['username']){
        echo "<div style='border:1px solid #aaa;padding:10px;margin:10px'>";
        echo "<b>{$a['title']}</b><br>";
        echo "{$a['desc']}<br>";
        if($a['file']) echo "<a href='{$a['file']}'>📎 ملف الواجب</a>";
        echo "</div>";
    }
}
?>

</body>
</html>