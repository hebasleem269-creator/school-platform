<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['role']!='student'){
    header("Location: login.php");
    exit;
}

$student = $_SESSION['username'];
$lesson = isset($_GET['lesson']) ? $_GET['lesson'] : '';

$assignments = file_exists("assignments.json") ? json_decode(file_get_contents("assignments.json"), true) : [];
$submissions = file_exists("submissions.json") ? json_decode(file_get_contents("submissions.json"), true) : [];
$grades = file_exists("grades.json") ? json_decode(file_get_contents("grades.json"), true) : [];
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>واجبات: <?php echo htmlspecialchars($lesson); ?></title>
<style>
body{direction:rtl;font-family:Arial,Tahoma;background:#e0f7fa;margin:0;padding:0;}
.container{max-width:900px;margin:30px auto;padding:25px;}
h2{text-align:center;color:#006064;}
.top-actions{display:flex;justify-content:flex-end;margin-bottom:20px;}
.btn{display:inline-block;padding:10px 20px;border-radius:8px;font-weight:bold;color:#fff;text-decoration:none;transition:0.3s;}
.back{background:#00838f;}
.back:hover{ background:#006064; }
.logout{background:#d32f2f;}
.logout:hover{ background:#b71c1c; }
.card{background:#ffffff;border-left:6px solid #00838f;padding:20px;margin:20px 0;border-radius:12px;box-shadow:0 3px 8px rgba(0,0,0,0.1);}
.card h3{margin-top:0;color:#004d40;}
.card p{color:#006064;}
form input[type=file]{display:block;margin-top:10px;}
form button{background:#00838f;color:#fff;border:none;padding:10px 15px;border-radius:8px;cursor:pointer;transition:0.3s;}
form button:hover{background:#006064;}
.grade-display{margin-top:10px;padding:10px;background:#b2dfdb;border-radius:8px;color:#004d40;font-weight:bold;}
</style>
</head>
<body dir="rtl">
<div class="container">
<h2>📝 واجبات درس: <?php echo htmlspecialchars($lesson); ?></h2>
<div class="top-actions">
    <a href="student.php" class="btn back">⬅ الرجوع للدروس</a>
    <a href="logout.php" class="btn logout">🚪 تسجيل الخروج</a>
</div>

<?php
$found=false;
foreach($assignments as $a){
    if($a['lesson']==$lesson){
        $found=true;
        echo "<div class='card'>";
        echo "<h3>{$a['title']}</h3>";
        echo "<p>".(isset($a['desc']) ? $a['desc'] : "لا يوجد وصف")."</p>";
        if(isset($a['file']) && $a['file']!=""){
            echo "<a href='{$a['file']}' target='_blank'>📄 تحميل الواجب</a><br>";
        }

        $submitted=false;
        foreach($submissions as $s){
            if($s['student']==$student && $s['assignment']==$a['title']){
                $submitted=true;
                echo "<p>✅ تم تسليم الواجب</p>";
                foreach($grades as $g){
                    if($g['student']==$student && $g['assignment']==$a['title']){
                        echo "<div class='grade-display'>";
                        echo "<b>✅ الدرجة:</b> {$g['grade']}<br>";
                        echo "<b>💬 تعليق المدرس:</b> {$g['note']}";
                        echo "</div>";
                    }
                }
            }
        }

        if(!$submitted){
            echo "<form action='submit_assignment.php' method='post' enctype='multipart/form-data'>";
            echo "<input type='hidden' name='student' value='{$student}'>";
            echo "<input type='hidden' name='assignment' value='{$a['title']}'>";
            echo "<input type='hidden' name='lesson' value='{$lesson}'>";
            echo "<input type='file' name='file' required>";
            echo "<button>📤 رفع الحل</button>";
            echo "</form>";
        }

        echo "</div>";
    }
}
if(!$found){
    echo "<p>لا توجد واجبات لهذا الدرس حتى الآن.</p>";
}
?>
</div>
</body>
</html>