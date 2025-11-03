<?php
include "../include/server.php";
if (session_status() === PHP_SESSION_NONE) session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure student is logged in
if (!isset($_SESSION['regno'])) {
    header("Location: ../logout.php");
    exit();
}

$regno = $_SESSION['regno'];

// Fetch student info
$studentQ = $dbcon->prepare("SELECT id, fullname FROM student WHERE regno = ? LIMIT 1");
$studentQ->bind_param("s", $regno);
$studentQ->execute();
$studentRes = $studentQ->get_result();
if ($studentRes->num_rows === 0) {
    die("Student not found.");
}
$student = $studentRes->fetch_assoc();
$student_id = (int)$student['id'];

// Exam parameters
$exam_schedule = isset($_GET['exam_schedule']) ? trim($_GET['exam_schedule']) : '';
$course_code   = isset($_GET['course_code']) ? trim($_GET['course_code']) : '';
$level_id      = isset($_GET['level']) ? intval($_GET['level']) : 0;

if (empty($exam_schedule) || empty($course_code) || $level_id <= 0) {
    die("Missing exam parameters.");
}

// Setup exam start & end time
date_default_timezone_set("Africa/Lagos");
$exam_start = new DateTime($exam_schedule);
$exam_end = clone $exam_start;
$exam_end->modify("+2 hours");
$exam_end_ts = $exam_end->getTimestamp();

// If time expired → redirect
if (new DateTime() > $exam_end) {
    echo "<script>alert('Exam time expired.'); window.location='index.php';</script>";
    exit();
}

// Get course info
$courseQ = $dbcon->prepare("SELECT id, course_title FROM course WHERE course_code = ? LIMIT 1");
$courseQ->bind_param("s", $course_code);
$courseQ->execute();
$courseRes = $courseQ->get_result();
if ($courseRes->num_rows === 0) {
    die("Course not found.");
}
$course = $courseRes->fetch_assoc();
$course_id = (int)$course['id'];
$course_title = $course['course_title'];

// Prevent retake
$checkQ = $dbcon->prepare("SELECT id FROM exam_results WHERE student_id = ? AND course_id = ? LIMIT 1");
$checkQ->bind_param("ii", $student_id, $course_id);
$checkQ->execute();
if ($checkQ->get_result()->num_rows > 0) {
    echo "<script>alert('You already took this exam.'); window.location='index.php';</script>";
    exit();
}

// Fetch questions and answers
$q_stmt = $dbcon->prepare("
    SELECT q.id AS question_id, q.question_text, q.exam_time,
           a.opt_a, a.opt_b, a.opt_c, a.opt_d, a.correct_option
    FROM questions q
    JOIN answer a ON q.id = a.question_id
    WHERE q.exam_schedule = ? AND q.course_id = ? AND q.level_id = ?
    ORDER BY q.id ASC
");
$q_stmt->bind_param("sii", $exam_schedule, $course_id, $level_id);
$q_stmt->execute();
$q_res = $q_stmt->get_result();

$questions = [];
$exam_time = 0;
while ($row = $q_res->fetch_assoc()) {
    $row['correct_option'] = strtoupper($row['correct_option']);
    $questions[] = $row;
    $exam_time = $row['exam_time'] ?: $exam_time;
}
$total_questions = count($questions);

// When submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $answers = $_POST['answers'] ?? [];
    $correct = 0;
    foreach ($questions as $q) {
        $qid = $q['question_id'];
        $student_choice = strtoupper(trim($answers[$qid] ?? ''));
        if ($student_choice === $q['correct_option']) $correct++;
    }
    $score = $total_questions > 0 ? round(($correct / $total_questions) * 100, 2) : 0.00;

    $ins = $dbcon->prepare("
        INSERT INTO exam_results (student_id, course_id, score, total_questions, correct_answers, exam_date)
        VALUES (?, ?, ?, ?, ?, NOW())
    ");
    $ins->bind_param("iisii", $student_id, $course_id, $score, $total_questions, $correct);
    if ($ins->execute()) {
        echo "<script>alert('Exam submitted successfully!'); window.location='index.php';</script>";
        exit();
    } else {
        die('Error saving exam result: ' . $dbcon->error);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($course_title) ?> Exam</title>
  <link href="../bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-2xl shadow-lg">
    <div class="flex justify-between items-center mb-4">
      <div>
        <h2 class="text-xl font-bold"><?= htmlspecialchars($course_title) ?> (<?= htmlspecialchars($course_code) ?>)</h2>
        <p class="text-gray-500">Student: <?= htmlspecialchars($student['fullname']) ?> (<?= htmlspecialchars($regno) ?>)</p>
      </div>
      <div class="text-right">
        <p class="text-sm text-gray-600">Ends: <?= $exam_end->format('H:i') ?></p>
        <p class="font-bold text-red-500" id="timer">--:--:--</p>
      </div>
    </div>

    <?php if ($total_questions === 0): ?>
      <p>No questions found for this exam.</p>
    <?php else: ?>
      <form method="POST" id="examForm">
        <?php foreach ($questions as $i => $q): ?>
          <div class="question <?= $i === 0 ? '' : 'hidden' ?>">
            <h3 class="font-semibold mb-3"><?= ($i+1) . ". " . htmlspecialchars($q['question_text']) ?></h3>
            <?php foreach (['A','B','C','D'] as $opt): ?>
              <?php $text = $q['opt_'.strtolower($opt)]; ?>
              <label class="block border rounded-xl p-3 mb-2 cursor-pointer hover:bg-gray-50">
                <input type="radio" name="answers[<?= $q['question_id'] ?>]" value="<?= $opt ?>"> 
                <strong><?= $opt ?>.</strong> <?= htmlspecialchars($text) ?>
              </label>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>

        <div class="flex justify-between items-center mt-6">
          <button type="button" id="prevBtn" class="px-4 py-2 bg-gray-300 rounded-xl" disabled>Previous</button>
          <span id="progress">1 / <?= $total_questions ?></span>
          <button type="button" id="nextBtn" class="px-4 py-2 bg-blue-600 text-white rounded-xl">Next</button>
        </div>
      </form>
    <?php endif; ?>
  </div>

  <script>
  const questions = Array.from(document.querySelectorAll('.question'));
  let idx = 0;
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const progress = document.getElementById('progress');
  const form = document.getElementById('examForm');

  function show(i){
    questions.forEach((q, j) => q.classList.toggle('hidden', j !== i));
    progress.textContent = (i+1) + " / " + questions.length;
    prevBtn.disabled = (i === 0);
    nextBtn.textContent = (i === questions.length - 1) ? "Submit" : "Next";
  }

  nextBtn.onclick = () => {
    if (idx < questions.length - 1) {
      idx++;
      show(idx);
    } else {
      if (confirm("Submit exam now?")) form.submit();
    }
  };

  prevBtn.onclick = () => {
    if (idx > 0) {
      idx--;
      show(idx);
    }
  };

  // Timer
  const end = <?= $exam_end_ts ?> * 1000;
  const timer = document.getElementById('timer');
  function tick(){
    const diff = Math.floor((end - Date.now())/1000);
    if (diff <= 0) {
      timer.textContent = "00:00:00";
      alert("Time up! Exam submitted automatically.");
      form.submit();
      return;
    }
    const h = String(Math.floor(diff/3600)).padStart(2,'0');
    const m = String(Math.floor((diff%3600)/60)).padStart(2,'0');
    const s = String(diff%60).padStart(2,'0');
    timer.textContent = `${h}:${m}:${s}`;
    setTimeout(tick,1000);
  }
  tick();

  // Auto-submit if student switches tab
  document.addEventListener("visibilitychange", () => {
    if (document.hidden) {
      alert("You left the exam page — it will be submitted automatically.");
      form.submit();
    }
  });
  </script>
</body>
</html>
