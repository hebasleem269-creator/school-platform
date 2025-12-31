<?php
session_start();
if($_SESSION['role']!='teacher') exit;

$lessons = file_exists("lessons.json")
    ? json_decode(file_get_contents("lessons.json"), true)
    : [];

$fileName = time().'_'.$_FILES['file']['name'];
move_uploaded_file($_FILES['file']['tmp_name'], "files/$fileName");

$lessons[] = [
    "teacher" => $_SESSION['username'],
    "title"   => $_POST['title'],
    "desc"    => $_POST['desc'],
    "file"    => "files/$fileName"
];

file_put_contents("lessons.json", json_encode($lessons, JSON_PRETTY_PRINT));
header("Location: teacher.php");