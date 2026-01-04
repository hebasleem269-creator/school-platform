<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'student'){
    header("Location: login.php");
    exit;
}

$student = $_SESSION['username'];

// ===== تحميل الإشعارات =====
$notifications_file = "notifications.json";
$notifications = file_exists($notifications_file) ? json_decode(file_get_contents($notifications_file), true) : [];

// ===== الدروس المتاحة =====
$lessons = [
    ["name" => "الرياضيات", "desc" => "درس أساسيات الجمع والطرح"],
    ["name" => "العلوم", "desc" => "درس عن النباتات"]
];
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>الدروس المتاحة</title>
<style>
body{
    direction: rtl;
    font-family: Arial, Tahoma;
    background:#e0f7fa;
    margin:0;
    padding:0;
}
.container{
    max-width:900px;
    margin:30px auto;
    padding:25px;
}
h2{
    text-align:center;
    color:#006064;
}
.card{
    background:#fff;
    padding:20px;
    margin:20px 0;
    border-radius:12px;
    box-shadow:0 3px 8px rgba(0,0,0,0.1);
}
.card h3{
    margin-top:0;
    color:#004d40;
}
.card p{
    color:#006064;
}
.btn{
    display:inline-block;
    padding:10px 20px;
    border-radius:8px;
    color:#fff;
    text-decoration:none;
    transition:0.3s;
}
.logout{
    background:#d32f2f;
}
.logout:hover{
    background:#b71c1c;
}
.assignment{
    background:#00838f;
}
.assignment:hover{
    background:#006064;
}
.notification{
    margin-bottom:15px;
}
.notification h3{
    margin-top:0;
}
.notification p{
    padding:8px;
    border-radius:6px;
    margin-bottom:5px;
}
</style>
</head>
<body dir="rtl">
<div class="container">

<!-- عرض الإشعارات -->
<?php if(!empty($notifications)): ?>
<div class="notification">
<h3>🔔 الإشعارات</h3>
<?php foreach($notifications as $n):
        if($n['for']=='all' || $n['for']==$student): 

        // تحديد اللون حسب نوع الإشعار
        switch($n['type']){
            case 'lesson': $bg="#bbdefb"; $color="#0d47a1"; break;
            case 'assignment': $bg="#c8e6c9"; $color="#1b5e20"; break;
            case 'payment': $bg="#ffe0b2"; $color="#e65100"; break;
            default: $bg="#fff3e0"; $color="#bf360c";
        }
?>
<p style="background:<?php echo $bg; ?>;color:<?php echo $color; ?>;">
[<?php echo htmlspecialchars($n['date']); ?>] <?php echo htmlspecialchars($n['message']); ?>
</p>
<?php endif; endforeach; ?>
</div>
<?php endif; ?>

<!-- ترحيب بالطالب -->
<h2>👩‍🎓 أهلاً <?php echo htmlspecialchars($student); ?></h2>
<a href="logout.php" class="btn logout">🚪 تسجيل الخروج</a>

<!-- عرض الدروس -->
<?php foreach($lessons as $lesson): ?>
<div class="card">
    <h3><?php echo htmlspecialchars($lesson['name']); ?></h3>
    <p><?php echo htmlspecialchars($lesson['desc']); ?></p>
    <a href="student_assignments.php?lesson=<?php echo urlencode($lesson['name']); ?>" class="btn assignment">📝 الواجبات</a>
</div>
<?php endforeach; ?>

</div>
</body>
</html>