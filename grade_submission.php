<?php
session_start();
if($_SESSION['role']!='teacher') exit;

$grades = file_exists("grades.json")
    ? json_decode(file_get_contents("grades.json"), true)
    : [];

$grades[] = [
    "student" => $_POST['student'],
    "assignment" => $_POST['assignment'],
    "grade" => $_POST['grade'],
    "note" => $_POST['note']
];

file_put_contents("grades.json", json_encode($grades, JSON_PRETTY_PRINT));

header("Location: submissions_teacher.php");