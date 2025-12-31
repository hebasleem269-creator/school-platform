<?php
// تحميل بيانات الطلاب من ملف students.json
$path = __DIR__ . "/students.json";
$data = file_exists($path) ? json_decode(file_get_contents($path), true) : [];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>قائمة الطلاب</title>
    <style>
        body { font-family: Arial; text-align: center; padding: 30px; background: #fafafa; }
        .card {
            background: #fff;
            padding: 20px;
            margin: 15px;
            border-radius: 15px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            display: inline-block;
            width: 250px;
            vertical-align: top;
        }
        img { border-radius: 10px; max-width: 120px; margin-bottom: 15px; }
        h2 { margin-bottom: 30px; }
    </style>
</head>
<body>
<h2>📋 قائمة الطلاب المسجلين</h2>

<?php
if (!empty($data)) {
    foreach ($data as $student) {
        $profile = htmlspecialchars($student['profile'] ?? "images/default.png");
        $name    = htmlspecialchars($student['name'] ?? "");
        $email   = htmlspecialchars($student['email'] ?? "");
        $school  = !empty($student['school']) ? htmlspecialchars($student['school']) : "غير محددة";
        $class   = !empty($student['class']) ? htmlspecialchars($student['class']) : "غير محدد";

        echo '<div class="card">';
        echo '<img src="' . $profile . '" alt="صورة الطالب">';
        echo '<p><strong>الاسم:</strong> ' . $name . '</p>';
        echo '<p><strong>