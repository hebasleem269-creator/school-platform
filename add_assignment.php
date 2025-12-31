<?php
session_start();
if($_SESSION['role']!='teacher') exit;

$assignments = file_exists("assignments.json")
    ? json_decode(file_get_contents("assignments.json"), true)
    : [];

$filePath = "";
if(!empty($_FILES['file']['name'])){
    $fileName = time().'_'.$_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], "files/$fileName");
    $filePath = "files/$fileName";
}

$assignments[] = [
    "teacher" => $_SESSION['username'],
    "title"   => $_POST['title'],
    "desc"    => $_POST['desc'],
    "file"    => $filePath
];

file_put_contents("assignments.json", json_encode($assignments, JSON_PRETTY_PRINT));
header("Location: teacher.php");