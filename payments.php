<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['role']!='teacher'){
    header("Location: login.php");
    exit;
}

$payments_file = "payments.json";
$payments = file_exists($payments_file) ? json_decode(file_get_contents($payments_file), true) : [];

// إضافة دفعة جديدة
if($_SERVER['REQUEST_METHOD']==='POST'){
    $new = [
        "student"=>$_POST['student'],
        "amount"=>$_POST['amount'],
        "reason"=>$_POST['reason'],
        "date"=>date("Y-m-d H:i:s")
    ];
    $payments[] = $new;
    file_put_contents($payments_file, json_encode($payments, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>💰 حساب المدفوعات</title>
<style>
body{direction:rtl;font-family:Arial;background:#f4f6f8;margin:0;padding:0}
.container{max-width:800px;margin:30px auto;padding:20px;background:#fff;border-radius:12px;box-shadow:0 4px 10px rgba(0,0,0,0.1)}
h2{text-align:center;color:#00695c}
form{display:flex;flex-direction:column;margin-bottom:20px}
input,select{padding:8px;margin:5px 0;border-radius:6px;border:1px solid #ccc;font-size:16px}
button{padding:10px 15px;background:#009688;color:#fff;border:none;border-radius:6px;cursor:pointer;transition:0.3s}
button:hover{background:#00796b}
table{width:100%;border-collapse:collapse;margin-top:15px}
th,td{border:1px solid #ccc;padding:8px;text-align:center}
th{background:#e0f2f1}
</style>
</head>
<body dir="rtl">
<div class="container">
<h2>💰 حساب المدفوعات</h2>

<form method="post">
    <label>اسم الطالب</label>
    <input type="text" name="student" required>
    
    <label>المبلغ</label>
    <input type="number" name="amount" required>
    
    <label>سبب الدفع</label>
    <input type="text" name="reason" required>
    
    <button type="submit">➕ إضافة</button>
</form>

<table>
<tr>
<th>الطالب</th>
<th>المبلغ</th>
<th>السبب</th>
<th>التاريخ</th>
</tr>
<?php foreach($payments as $p): ?>
<tr>
<td><?= htmlspecialchars($p['student']) ?></td>
<td><?= htmlspecialchars($p['amount']) ?></td>
<td><?= htmlspecialchars($p['reason']) ?></td>
<td><?= htmlspecialchars($p['date']) ?></td>
</tr>
<?php endforeach; ?>
</table>

<a href="teacher.php" style="display:inline-block;margin-top:15px;text-decoration:none;background:#009688;color:#fff;padding:10px 20px;border-radius:8px">⬅ الرجوع</a>
</div>
</body>
</html>