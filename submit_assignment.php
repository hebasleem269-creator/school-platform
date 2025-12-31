<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['role']!='student'){
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $student = $_POST['student'];
    $assignment = $_POST['assignment'];
    $lesson = $_POST['lesson'];

    if(isset($_FILES['file']) && $_FILES['file']['error'] == 0){
        $uploadDir = "uploads/";
        if(!is_dir($uploadDir)){
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES['file']['name']);
        $targetFile = $uploadDir . $fileName;

        if(move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)){
            $subsFile = "submissions.json";
            $subs = file_exists($subsFile) ? json_decode(file_get_contents($subsFile), true) : [];

            $subs[] = [
                "student" => $student,
                "assignment" => $assignment,
                "file" => $targetFile,
                "submitted_at" => date("Y-m-d H:i:s")
            ];

            file_put_contents($subsFile, json_encode($subs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            header("Location: student_assignments.php?lesson=" . urlencode($lesson));
            exit;
        } else {
            $error = "حدث خطأ أثناء رفع الملف.";
        }
    } else {
        $error = "لم يتم اختيار أي ملف.";
    }
} else {
    $error = "طلب غير صالح.";
}

echo "<p style='color:red;'>{$error}</p>";
echo "<a href='student.php'>⬅ العودة للدروس</a>";
?>