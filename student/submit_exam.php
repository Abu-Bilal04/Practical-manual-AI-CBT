<?php
include "../include/server.php";
if (session_status() === PHP_SESSION_NONE) session_start();

// Ensure logged in
if (!isset($_SESSION['regno'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

// Get JSON data
$data = json_decode(file_get_contents("php://input"), true);
$student_id = intval($data['student_id'] ?? 0);
$answers = $data['answers'] ?? [];

if (!$student_id || empty($answers)) {
    echo json_encode(["status" => "error", "message" => "Invalid submission"]);
    exit();
}

foreach ($answers as $question_id => $chosen_option) {
    $question_id = intval($question_id);
    $chosen_option = intval($chosen_option);

    // Get correct answer
    $sql = "SELECT correct_option FROM answer WHERE question_id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->bind_param("i", $question_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $correct_option = intval($row['correct_option']);

    // Check correctness
    $is_correct = ($chosen_option === $correct_option) ? 1 : 0;

    // ✅ Insert or update (avoid duplicates)
    $sql_insert = "INSERT INTO student_answers (student_id, question_id, chosen_option, is_correct, created_at)
                   VALUES (?, ?, ?, ?, NOW())
                   ON DUPLICATE KEY UPDATE chosen_option = VALUES(chosen_option), 
                                           is_correct = VALUES(is_correct), 
                                           created_at = NOW()";
    $stmt2 = $dbcon->prepare($sql_insert);
    $stmt2->bind_param("iiii", $student_id, $question_id, $chosen_option, $is_correct);
    $stmt2->execute();
}

echo json_encode(["status" => "success", "message" => "Exam submitted successfully"]);
exit();
?>
