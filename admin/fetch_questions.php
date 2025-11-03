<?php
include "../include/server.php";

if (!isset($_GET['course_id'])) {
    echo json_encode([]);
    exit();
}

$course_id = intval($_GET['course_id']);
$sql = "SELECT question_text, correct_answer FROM questions WHERE course_id = ?";
$stmt = $dbcon->prepare($sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$res = $stmt->get_result();

$questions = [];
while ($row = $res->fetch_assoc()) {
    $questions[] = $row;
}

echo json_encode($questions);
