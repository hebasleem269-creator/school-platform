<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['role']!='student'){
    header("Location: login.php");
    exit;
}

$student = $_SESSION['username'];
$payments_file = "payments.json";
$payments = file_exists($payments_file) ? json_decode(file_get_contents($payments_file), true) : [];
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>💰 مدفوعاتي</title>
<style>
body{direction:rtl;font-family:Arial;background:#f4f6f8;margin:0;padding:0}
.container{max-width:700px;margin:30px auto;padding:20px;background:#fff;border-radius:12px;box-shadow:0 4px 10px rgba(0,0,0,0.1)}
h2{text-align:center;color:#00695c}
table{width:100%;border-collapse:collapse;margin-top:15px}
th,td{border:1px solid #ccc;padding:8px;text-align:center}
th{background:#e0f2f1}
.back{display:inline-block;margin-top:15px;text-decoration:none;background:#009688;color:#fff;padding:10px 20px;border-radius:8px}
</style>
</head>
<body dir="rtl">
<div class="container">
<h2>💰 مدفوعاتي</h2>

<table>
<tr>
<th>الطالب</th>
<th>المبلغ</th>
<th>السبب</th>
<th>التاريخ</th>
</tr>
<?php foreach($payments as $p): 
      if($p['student']==$student): ?>
<tr>
<td><?= htmlspecialchars($p['student']) ?></td>
<td><?= htmlspecialchars($p['amount']) ?></td>
<td><?= htmlspecialchars($p['reason']) ?></td>
<td><?= htmlspecialchars($p['date']) ?></td>
</tr>
<?php endif; endforeach; ?>
</table>

<a href="student.php" class="back">⬅ الرجوع</a>
</div>
</body>
</html>