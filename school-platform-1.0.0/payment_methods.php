<?php
session_start();
$file = "payment_numbers.json";

// إنشاء الملف إذا لم يكن موجود
if(!file_exists($file)){
    file_put_contents($file, json_encode([
        "vodafone" => ["number"=>"", "hint"=>"حوّل المبلغ على رقم فودافون وأرسل صورة التحويل"],
        "etisalat" => ["number"=>"", "hint"=>"حوّل المبلغ على رقم اتصالات وأرسل صورة التحويل"],
        "orange" => ["number"=>"", "hint"=>"حوّل المبلغ على رقم أورنج وأرسل صورة التحويل"],
        "instapay" => ["number"=>"", "hint"=>"حوّل المبلغ على الحساب وارسله للمدرس"]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// جلب البيانات الحالية
$numbers = json_decode(file_get_contents($file), true);

// حفظ الأرقام لو المدرس عدّل
$success = false;
if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_SESSION['role']) && $_SESSION['role']=="teacher"){
    $numbers = [
        "vodafone" => ["number"=>$_POST['vodafone'], "hint"=>$numbers['vodafone']['hint']],
        "etisalat" => ["number"=>$_POST['etisalat'], "hint"=>$numbers['etisalat']['hint']],
        "orange" => ["number"=>$_POST['orange'], "hint"=>$numbers['orange']['hint']],
        "instapay" => ["number"=>$_POST['instapay'], "hint"=>$numbers['instapay']['hint']]
    ];
    file_put_contents($file, json_encode($numbers, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>💳 طرق الدفع</title>
<style>
body{direction:rtl;font-family:Arial;background:#f4f6f8;margin:0;padding:0}
.box{max-width:700px;margin:40px auto;background:#fff;padding:25px;border-radius:12px;box-shadow:0 4px 10px rgba(0,0,0,0.1)}
h2{text-align:center;color:#00695c;margin-bottom:20px}
.method{padding:15px;margin:15px 0;border-radius:10px;display:flex;justify-content:space-between;align-items:center;font-size:18px;flex-wrap:wrap}
.copy-btn, .save-btn{background:#009688;color:#fff;border:none;padding:8px 12px;border-radius:6px;cursor:pointer;font-size:14px;margin-left:10px}
.copy-btn:hover, .save-btn:hover{background:#00796b}
.back{display:inline-block;margin-top:20px;text-decoration:none;background:#009688;color:#fff;padding:10px 20px;border-radius:8px}
input{padding:6px;width:60%;border-radius:6px;border:1px solid #ccc;font-size:16px;margin-top:5px}
form{display:flex;flex-direction:column}
.success-msg{text-align:center;color:#00695c;font-weight:bold;margin-bottom:15px}
.hint{width:100%;font-size:14px;margin-top:5px}
.vodafone{background:#e1f5fe; border-left:5px solid #03a9f4; color:#01579b}
.etisalat{background:#f1f8e9; border-left:5px solid #8bc34a; color:#33691e}
.orange{background:#fff3e0; border-left:5px solid #ff9800; color:#e65100}
.instapay{background:#fce4ec; border-left:5px solid #e91e63; color:#880e4f}
</style>
</head>
<body dir="rtl">
<div class="box">
<h2>💳 طرق الدفع المتاحة</h2>

<?php if($success): ?>
<p class="success-msg">✅ تم حفظ الأرقام بنجاح!</p>
<?php endif; ?>

<?php if(isset($_SESSION['role']) && $_SESSION['role']=="teacher"): ?>
<form method="post">
    <div class="method vodafone">
        <span>📱 فودافون كاش:</span>
        <input type="text" name="vodafone" value="<?= htmlspecialchars($numbers['vodafone']['number'] ?? '') ?>" placeholder="أدخل رقم فودافون">
    </div>
    <div class="method etisalat">
        <span>📱 اتصالات كاش:</span>
        <input type="text" name="etisalat" value="<?= htmlspecialchars($numbers['etisalat']['number'] ?? '') ?>" placeholder="أدخل رقم اتصالات">
    </div>
    <div class="method orange">
        <span>📱 أورنج كاش:</span>
        <input type="text" name="orange" value="<?= htmlspecialchars($numbers['orange']['number'] ?? '') ?>" placeholder="أدخل رقم أورنج">
    </div>
    <div class="method instapay">
        <span>🏦 InstaPay:</span>
        <input type="text" name="instapay" value="<?= htmlspecialchars($numbers['instapay']['number'] ?? '') ?>" placeholder="أدخل اسم الحساب">
    </div>
    <button type="submit" class="save-btn">💾 حفظ الأرقام</button>
</form>
<?php else: ?>
<div class="method vodafone">
    <span>📱 فودافون كاش: <b><?= htmlspecialchars($numbers['vodafone']['number'] ?? '') ?></b></span>
    <button class="copy-btn" onclick="copyText('<?= htmlspecialchars($numbers['vodafone']['number'] ?? '') ?>')">نسخ الرقم</button>
    <p class="hint"><?= htmlspecialchars($numbers['vodafone']['hint'] ?? '') ?></p>
</div>

<div class="method etisalat">
    <span>📱 اتصالات كاش: <b><?= htmlspecialchars($numbers['etisalat']['number'] ?? '') ?></b></span>
    <button class="copy-btn" onclick="copyText('<?= htmlspecialchars($numbers['etisalat']['number'] ?? '') ?>')">نسخ الرقم</button>
    <p class="hint"><?= htmlspecialchars($numbers['etisalat']['hint'] ?? '') ?></p>
</div>

<div class="method orange">
    <span>📱 أورنج كاش: <b><?= htmlspecialchars($numbers['orange']['number'] ?? '') ?></b></span>
    <button class="copy-btn" onclick="copyText('<?= htmlspecialchars($numbers['orange']['number'] ?? '') ?>')">نسخ الرقم</button>
    <p class="hint"><?= htmlspecialchars($numbers['orange']['hint'] ?? '') ?></p>
</div>

<div class="method instapay">
    <span>🏦 InstaPay: <b><?= htmlspecialchars($numbers['instapay']['number'] ?? '') ?></b></span>
    <button class="copy-btn" onclick="copyText('<?= htmlspecialchars($numbers['instapay']['number'] ?? '') ?>')">نسخ الرقم</button>
    <p class="hint"><?= htmlspecialchars($numbers['instapay']['hint'] ?? '') ?></p>
</div>
<?php endif; ?>

<a href="<?= (isset($_SESSION['role']) && $_SESSION['role']=="student") ? 'student.php' : 'teacher.php' ?>" class="back">⬅ الرجوع</a>
</div>

<script>
function copyText(text){
    if(text.trim() === "") { alert("⚠️ لا يوجد رقم ليتم نسخه"); return; }
    navigator.clipboard.writeText(text).then(() => {
        alert("✅ تم نسخ الرقم: " + text);
    });
}
</script>
</body>
</html>