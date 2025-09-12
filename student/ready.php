<!doctype html>
<html lang="en" data-pc-theme="light">
<head>
  <meta charset="UTF-8">
  <title>Exam Rules || Practical Manual System</title>
  <link rel="stylesheet" href="../dist/assets/css/style.css" />
  <link rel="stylesheet" href="../bootstrap-icons/bootstrap-icons.css">
</head>

<body class="bg-gray-100">
<?php
// DB connection
include "../include/server.php";

if (session_status() === PHP_SESSION_NONE) session_start();

// Get student info from session
$regno = $_SESSION['regno'] ?? '';
$sql = "SELECT fullname, regno FROM student WHERE regno = ?";
$stmt = $dbcon->prepare($sql);
$stmt->bind_param("s", $regno);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

// Get exam details from query string
$course_code   = $_GET['course_code'] ?? '';
$level         = $_GET['level'] ?? '';
$exam_schedule = $_GET['exam_schedule'] ?? '';
$exam_time     = $_GET['exam_time'] ?? '';

// Fetch course title from DB using course_code
$course_title = '';
if (!empty($course_code)) {
    $sql_course = "SELECT course_title FROM course WHERE course_code = ?";
    $stmt = $dbcon->prepare($sql_course);
    $stmt->bind_param("s", $course_code);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $course_title = $row['course_title'];
    }
}

// Format schedule to readable form
$exam_display = $exam_schedule ? date("Y-m-d h:ia", strtotime($exam_schedule)) : '';
?>
  <div class="pc-container">
    <div class="pc-content flex items-center justify-center min-h-screen">
      <div class="card w-full max-w-2xl shadow-xl rounded-2xl">
        <div class="card-header bg-primary-500 text-white rounded-t-2xl p-4">
          <h4 class="mb-0">Exam Instructions</h4>
        </div>
        <div class="card-body p-6">
          
          <!-- Student Info -->
          <div class="mb-6 space-y-1">
            <h6><strong>Name:</strong> <?= htmlspecialchars($student['fullname'] ?? '') ?></h6>
            <h6><strong>Reg No:</strong> <?= htmlspecialchars($student['regno'] ?? '') ?></h6>
            <h6><strong>Course Title:</strong> <?= htmlspecialchars($course_title) ?></h6>
            <h6><strong>Course Code:</strong> <?= htmlspecialchars($course_code) ?></h6>
            <h6><strong>Level:</strong> <?= htmlspecialchars($level) ?></h6>
            <h6><strong>Exam Date & Time:</strong> <?= htmlspecialchars($exam_display) ?></h6>
            <h6 class="flex items-center gap-2 text-primary">
              <i class="bi bi-clock-history"></i>
              <strong>Exam Duration:</strong> <?= htmlspecialchars($exam_time) ?> minutes
            </h6>
          </div>

          <!-- Exam Rules -->
          <div class="mb-6">
            <h5 class="mb-3 font-medium">Exam Rules</h5>
            <ol class="list-decimal list-inside space-y-2 text-gray-700">
              <li>Ensure a stable internet connection throughout the exam.</li>
              <li>No use of textbooks, notes, or online resources.</li>
              <li>Do not refresh or close the browser during the test.</li>
              <li>Switching tabs will automatically submit the exam.</li>
              <li>Any attempt at cheating will result in disqualification.</li>
            </ol>
          </div>

          <!-- Get Started Button -->
          <div class="text-center">
            <a href="exam.php?exam_schedule=<?= urlencode($exam_schedule) ?>&course_code=<?= urlencode($course_code) ?>&level=<?= urlencode($level) ?>"
               class="btn btn-primary px-6 py-2 text-lg rounded-full">
              Get Started
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>
</body>
</html>
