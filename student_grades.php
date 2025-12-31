<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['role']!='student'){
    header("Location: login.php");
    exit;
}

$student = $_SESSION['username'];

$grades = file_exists("grades.json") ? json_decode(file_get_contents("grades.json"), true) : [];
$subs = file_exists("submissions.json") ? json_decode(file_get_contents("submissions.json"), true) : [];
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>درجاتي</title>
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
    background:#fff;
    padding:25px;
    border-radius:15px;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
}
h2{
    color:#006064;
    text-align:center;
}
.card{
    border-left:6px solid #00838f;
    padding:20px;
    margin:20px 0;
    border-radius:12px;
    background:#e0f2f1;
}
.card b{
    display:inline-block;
    width:120px;
    color:#004d40;
    font-weight:bold;
}
.grade-display{
    margin-top:15px;
    padding:10px;
    background:#b2dfdb;
    border-radius:8px;
    color:#004d40;
    font-weight:bold;
}
.download{
    display:inline-block;
    margin-top:10px;
    background:#43a047;
    color:#fff;
    padding:8px 12px;
    border-radius:8px;
    text-decoration:none;
}
.download:hover{
    background:#2e7d32;
}
</style>
</head>
<body>
<div class="container">
<h2>📚 درجاتي</h2>
<?php
$found=false;
foreach($subs as $s){
    if($s['student']==$student){
        $found=true;
        echo "<div class='card'>";
        echo "<b>📝 الواجب:</b> {$s['assignment']}<br>";
        echo "<a class='download' href='{$s['file']}'>📄 تحميل الحل</a><br>";

        // ابحث عن التقييم
        $grade_found=false;
        foreach($grades as $g){
            if($g['student']==$student && $g['assignment']==$s['assignment']){
                echo "<div class='grade-display'>";
                echo "<b>✅ الدرجة:</b> {$g['grade']}<br>";
                echo "<b>💬 تعليق المدرس:</b> {$g['note']}";
                echo "</div>";
                $grade_found=true;
            }
        }
        if(!$grade_found){
            echo "<div class='grade-display' style='background:#ffccbc;color:#bf360c;'>لم يتم تقييم هذا الواجب بعد</div>";
        }

        echo "</div>";
    }
}
if(!$found){
    echo "لم تقم بتسليم أي واجبات بعد.";
}
?>
</div>
</body>
</html>