<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['role']!='teacher'){
    header("Location: teacher.php");
    exit;
}

$subs = file_exists("submissions.json") ? json_decode(file_get_contents("submissions.json"), true) : [];
$grades = file_exists("grades.json") ? json_decode(file_get_contents("grades.json"), true) : [];
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>تسليمات الطلاب</title>
<style>
body{
    direction: rtl;
    font-family: Arial, Tahoma;
    background:#f2f4f8;
    margin:0;
    padding:0;
}
.container{
    max-width:900px;
    margin:30px auto;
    background:#fff;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,.1);
}
h2{
    color:#333;
    margin-top:0;
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
    text-decoration:none;
}
.back{
    background:#1e88e5;
}
.back:hover{ background:#1565c0; }
.card{
    border-left:6px solid #1e88e5;
    padding:20px;
    margin:20px 0;
    border-radius:10px;
    background:#f9f9f9;
}
.card b{
    display:inline-block;
    width:120px;
    color:#333;
    font-weight:bold;
}
.download{
    display:inline-block;
    margin-top:10px;
    background:#43a047;
    color:#fff;
    padding:8px 12px;
    border-radius:6px;
    text-decoration:none;
}
.download:hover{
    background:#2e7d32;
}
form{
    margin-top:15px;
    padding:15px;
    background:#fff;
    border:1px solid #ddd;
    border-radius:8px;
}
form input[type=number],
form textarea{
    width:100%;
    padding:10px;
    margin-bottom:10px;
    border:1px solid #ccc;
    border-radius:6px;
}
form textarea{
    min-height:60px;
    resize:vertical;
}
form button{
    background:#1e88e5;
    color:#fff;
    border:none;
    padding:10px 20px;
    border-radius:6px;
    cursor:pointer;
    font-size:16px;
}
form button:hover{
    background:#1565c0;
}
.grade-display{
    margin-top:15px;
    padding:10px;
    background:#e3f2fd;
    border-radius:6px;
}
body{
    direction: rtl;
    font-family: Arial, Tahoma;
    background:#e0f7fa; /* خلفية فاتحة ملونة */
    margin:0;
    padding:0;
}

.container{
    max-width:900px;
    margin:30px auto;
    background:#ffffff;
    padding:25px;
    border-radius:15px;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
}

h2{
    color:#006064; /* أزرق داكن */
    text-align:center;
}

.top-actions{
    display:flex;
    gap:10px;
    margin-bottom:20px;
}

.btn{
    display:inline-block;
    padding:10px 20px;
    border-radius:8px;
    font-weight:bold;
    color:#fff;
    text-decoration:none;
    transition:0.3s;
}

.back{
    background:#00838f; /* لون أزرق */
}
.back:hover{ background:#006064; }

.card{
    border-left:6px solid #00838f;
    padding:20px;
    margin:20px 0;
    border-radius:12px;
    background:#e0f2f1; /* أخضر فاتح */
    transition:0.3s;
}
.card:hover{
    background:#b2dfdb;
}

.card b{
    display:inline-block;
    width:120px;
    color:#004d40;
    font-weight:bold;
}

.download{
    display:inline-block;
    margin-top:10px;
    background:#43a047; /* أخضر */
    color:#fff;
    padding:8px 12px;
    border-radius:8px;
    text-decoration:none;
    transition:0.3s;
}
.download:hover{
    background:#2e7d32;
}

form{
    margin-top:15px;
    padding:15px;
    background:#ffffff;
    border:2px solid #4dd0e1;
    border-radius:10px;
}

form input[type=number],
form textarea{
    width:100%;
    padding:10px;
    margin-bottom:10px;
    border:1px solid #80deea;
    border-radius:8px;
}

form textarea{
    min-height:60px;
    resize:vertical;
}

form button{
    background:#00838f;
    color:#fff;
    border:none;
    padding:12px 25px;
    border-radius:8px;
    cursor:pointer;
    font-size:16px;
    transition:0.3s;
}

form button:hover{
    background:#006064;
}

.grade-display{
    margin-top:15px;
    padding:10px;
    background:#b2dfdb; /* أخضر فاتح */
    border-radius:8px;
    color:#004d40;
    font-weight:bold;
}
</style>
</head>
<body dir="rtl">
<div class="container">
<h2>📥 تسليمات الطلاب</h2>
<div class="top-actions">
    <a href="teacher.php" class="btn back">⬅ الرجوع لصفحة المدرس</a>
</div>
<hr>

<?php
if(empty($subs)){
    echo "لا يوجد تسليمات حتى الآن";
}

foreach($subs as $s):
?>
<div class="card">
    <b>👤 الطالب:</b> <?php echo $s['student']; ?><br>
    <b>📝 الواجب:</b> <?php echo $s['assignment']; ?><br>
    <a class="download" href="<?php echo $s['file']; ?>">📄 تحميل الحل</a>

    <!-- فورم التقييم -->
    <form action="grade_submission.php" method="post">
        <input type="hidden" name="student" value="<?php echo $s['student']; ?>">
        <input type="hidden" name="assignment" value="<?php echo $s['assignment']; ?>">
        <input type="number" name="grade" placeholder="الدرجة" required>
        <textarea name="note" placeholder="تعليق المدرس"></textarea>
        <button>💾 حفظ التقييم</button>
    </form>

    <!-- عرض التقييم السابق إن وجد -->
    <?php
    foreach($grades as $g){
        if($g['student']==$s['student'] && $g['assignment']==$s['assignment']){
            echo "<div class='grade-display'>";
            echo "<b>✅ الدرجة:</b> {$g['grade']}<br>";
            echo "<b>💬 تعليق المدرس:</b> {$g['note']}";
            echo "</div>";
        }
    }
    ?>
</div>
<?php endforeach; ?>

</div>
</body>
</html>