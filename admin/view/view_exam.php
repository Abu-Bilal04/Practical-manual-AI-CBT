<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../../include/db_connection.php"); // adjust path if needed

if (!isset($_GET['exam_id'])) {
    die("❌ Exam ID is missing.");
}
$exam_id = intval($_GET['exam_id']);

// Fetch exam details (group of questions by session, level, course, schedule)
$sql_exam = "SELECT * FROM questions WHERE id = $exam_id LIMIT 1";
$res_exam = mysqli_query($dbcon, $sql_exam) or die("❌ Error fetching exam: " . mysqli_error($dbcon));

if (mysqli_num_rows($res_exam) === 0) {
    die("❌ Exam not found.");
}
$exam = mysqli_fetch_assoc($res_exam);

// Fetch all questions belonging to same session, level, course, schedule
$sql_questions = "
    SELECT q.id AS question_id, q.question_text, a.opt_a, a.opt_b, a.opt_c, a.opt_d, a.correct_option
    FROM questions q
    JOIN answer a ON q.id = a.question_id
    WHERE q.session_id    = '{$exam['session_id']}'
      AND q.level_id      = '{$exam['level_id']}'
      AND q.course_id     = '{$exam['course_id']}'
      AND q.exam_time     = '{$exam['exam_time']}'
      AND q.exam_schedule = '{$exam['exam_schedule']}'
    ORDER BY q.id ASC
";

$res_questions = mysqli_query($dbcon, $sql_questions) or die("❌ Error fetching questions: " . mysqli_error($dbcon));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Exam</title>
    <link rel="stylesheet" href="../../dist/assets/css/style.css">
    <link rel="stylesheet" href="../../bootstrap-icons/bootstrap-icons.css">
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .question-box { margin-bottom: 20px; padding: 15px; border: 1px solid #ccc; border-radius: 8px; }
        .correct { font-weight: bold; color: green; }
        .back-btn { display: inline-block; margin-bottom: 15px; padding: 8px 15px; background: #007bff; color: #fff; border-radius: 5px; text-decoration: none; }
        .back-btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    <a href="../questions.php" class="back-btn"><i class="bi bi-arrow-left-circle"></i> Back</a>

    <h3>Exam Details</h3>
    <p><b>Session ID:</b> <?= htmlspecialchars($exam['session_id']) ?></p>
    <p><b>Level ID:</b> <?= htmlspecialchars($exam['level_id']) ?></p>
    <p><b>Course ID:</b> <?= htmlspecialchars($exam['course_id']) ?></p>
    <p><b>Exam Time:</b> <?= htmlspecialchars($exam['exam_time']) ?> minutes</p>
    <p><b>Exam Schedule:</b> <?= htmlspecialchars($exam['exam_schedule']) ?></p>
    <hr>

    <h3>Questions</h3>
    <?php 
    if (mysqli_num_rows($res_questions) === 0): 
        echo "<p>No questions found for this exam.</p>";
    else: 
        $sn = 1;
        while ($row = mysqli_fetch_assoc($res_questions)): ?>
            <div class="question-box">
                <h5>Q<?= $sn++ ?>: <?= htmlspecialchars($row['question_text']) ?></h5>
                <ul>
                    <li <?= ($row['correct_option'] == 'A' ? 'class="correct"' : '') ?>>A. <?= htmlspecialchars($row['opt_a']) ?></li>
                    <li <?= ($row['correct_option'] == 'B' ? 'class="correct"' : '') ?>>B. <?= htmlspecialchars($row['opt_b']) ?></li>
                    <li <?= ($row['correct_option'] == 'C' ? 'class="correct"' : '') ?>>C. <?= htmlspecialchars($row['opt_c']) ?></li>
                    <li <?= ($row['correct_option'] == 'D' ? 'class="correct"' : '') ?>>D. <?= htmlspecialchars($row['opt_d']) ?></li>
                </ul>
                <p><b>Correct Answer:</b> <span class="correct"><?= htmlspecialchars($row['correct_option']) ?></span></p>
            </div>
    <?php endwhile; endif; ?>
</body>
</html>
