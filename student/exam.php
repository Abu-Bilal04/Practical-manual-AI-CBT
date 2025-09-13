<?php
include "../include/server.php";
if (session_status() === PHP_SESSION_NONE) session_start();

// ✅ Ensure logged in
if (!isset($_SESSION['regno'])) {
    header("Location: ../logout.php");
    exit();
}

// ✅ Student info
$regno = $_SESSION['regno'];
$studentQ = $dbcon->prepare("SELECT id, fullname FROM student WHERE regno = ? LIMIT 1");
$studentQ->bind_param("s", $regno);
$studentQ->execute();
$student = $studentQ->get_result()->fetch_assoc();
$student_id = $student['id'] ?? 0;

// ✅ Exam Params
$exam_schedule = $_GET['exam_schedule'] ?? '';
$course_code   = $_GET['course_code'] ?? '';
$level_id      = $_GET['level'] ?? '';

// Convert to DateTime
date_default_timezone_set("Africa/Lagos");
$exam_start = new DateTime($exam_schedule);
$exam_end   = clone $exam_start;
$exam_end->modify("+2 hours");

// Server-side validation: if current time > exam_end, redirect immediately
if (new DateTime() > $exam_end) {
    header("Location: index.php?msg=exam_expired");
    exit();
}

// ✅ Fetch course info
$courseQ = $dbcon->prepare("SELECT id, course_title FROM course WHERE course_code = ? LIMIT 1");
$courseQ->bind_param("s", $course_code);
$courseQ->execute();
$course = $courseQ->get_result()->fetch_assoc();
$course_id = $course['id'] ?? 0;
$course_title = $course['course_title'] ?? '';

// ✅ Fetch Questions + Answers
$sql = "SELECT q.id AS question_id, q.question_text, q.exam_time, 
               a.opt_a, a.opt_b, a.opt_c, a.opt_d
        FROM questions q
        JOIN answer a ON q.id = a.question_id
        WHERE q.exam_schedule = ? AND q.course_id = ? AND q.level_id = ?";
$stmt = $dbcon->prepare($sql);
$stmt->bind_param("sii", $exam_schedule, $course_id, $level_id);
$stmt->execute();
$res = $stmt->get_result();

$questions = [];
$exam_time = 0;
while ($row = $res->fetch_assoc()) {
    $questions[] = $row;
    $exam_time = $row['exam_time']; // same for all questions
}

// ✅ Encode for JS
$questions_json = json_encode($questions);

// Pass exam_end timestamp to JS
$exam_end_ts = $exam_end->getTimestamp();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Exam Page || Practical Manual System</title>
  <link rel="stylesheet" href="../dist/assets/css/style.css" />
  <link rel="stylesheet" href="../bootstrap-icons/bootstrap-icons.css">
  <style>
    .question-card { min-height: 250px; }
    .option { 
      border: 1px solid #ccc; 
      padding: 10px; 
      border-radius: 6px; 
      cursor: pointer; 
      display: flex; 
      align-items: center; 
      gap: 10px;
      transition: all 0.2s ease;
    }
    .option:hover { background: #f1f1f1; }
    .option.active { 
      border-color: #2563eb; 
      background: #e0f2fe; 
      font-weight: bold; 
      color: #1e3a8a;
    }
  </style>
</head>

<body class="bg-gray-100">

  <div class="pc-container">
    <div class="pc-content flex flex-col items-center min-h-screen py-10">

      <!-- Header -->
      <div class="w-full max-w-3xl bg-white shadow-lg rounded-xl p-6 mb-6">
        <div class="flex justify-between items-center">
          <div>
            <h4 class="font-bold"><?= htmlspecialchars($course_code) ?></h4>
            <p class="text-gray-600"><?= htmlspecialchars($course_title) ?></p>
          </div>
          <div class="text-right">
            <i class="bi bi-clock-history text-primary"></i>
            <span id="exam-timer" class="font-bold text-lg">00:00:00</span>
          </div>
        </div>
      </div>

      <!-- Question Box -->
      <div class="w-full max-w-3xl bg-white shadow-lg rounded-xl p-6 question-card">
        <div id="question-text" class="mb-4 font-medium text-lg">
          Loading question...
        </div>
        <div id="options" class="space-y-3"></div>
      </div>

      <!-- Footer Navigation -->
      <div class="w-full max-w-3xl bg-white shadow-lg rounded-xl p-4 mt-4 flex justify-between items-center">
        <button id="prev-btn" class="btn btn-secondary px-4 py-2" disabled>Previous</button>
        <span id="progress" class="font-medium">0 out of 0</span>
        <button id="next-btn" class="btn btn-primary px-4 py-2">Next</button>
      </div>

    </div>
  </div>

  <script>
    const questions = <?= $questions_json ?>;
    const examTimeInSeconds = <?= intval($exam_time) ?> * 60;
    const studentId = <?= intval($student_id) ?>;
    const examEndTimestamp = <?= $exam_end_ts ?> * 1000; // milliseconds

    let currentQuestion = 0;
    let answers = {}; 
    let examSubmitted = false;

    const optionLabels = ["A", "B", "C", "D"];

    function loadQuestion() {
      const q = questions[currentQuestion];
      document.getElementById("question-text").innerText = q.question_text;
      document.getElementById("progress").innerText = (currentQuestion + 1) + " out of " + questions.length;

      const optionsDiv = document.getElementById("options");
      optionsDiv.innerHTML = "";
      const opts = [q.opt_a, q.opt_b, q.opt_c, q.opt_d];
      opts.forEach((opt, i) => {
        const div = document.createElement("label");
        div.classList.add("option");
        const chosen = answers[q.question_id] == i;
        if (chosen) div.classList.add("active");
        div.innerHTML = `<input type="radio" name="option" value="${i}" ${chosen ? "checked" : ""}><strong>${optionLabels[i]}.</strong> ${opt}`;
        div.addEventListener("click", () => {
          answers[q.question_id] = i;
          loadQuestion();
        });
        optionsDiv.appendChild(div);
      });

      document.getElementById("prev-btn").disabled = currentQuestion === 0;
      document.getElementById("next-btn").innerText = currentQuestion === questions.length - 1 ? "Submit" : "Next";
    }

    document.getElementById("prev-btn").addEventListener("click", () => {
      if (currentQuestion > 0) {
        currentQuestion--;
        loadQuestion();
      }
    });

    document.getElementById("next-btn").addEventListener("click", () => {
      if (currentQuestion < questions.length - 1) {
        currentQuestion++;
        loadQuestion();
      } else {
        submitExam();
      }
    });

    // ✅ Submit exam
    function submitExam() {
      if (examSubmitted) return;
      examSubmitted = true;

      fetch("exam.php", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({
          student_id: studentId,
          answers: answers
        })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          alert("✅ Exam submitted successfully!");
          window.location.href = "index.php";
        } else {
          alert("❌ Error: " + data.message);
          examSubmitted = false; // allow retry
        }
      })
      .catch(err => {
        alert("Error submitting exam: " + err);
        examSubmitted = false; // allow retry
      });
    }

    // Countdown Timer
    function startCountdown(duration, display) {
      let timer = duration;
      const interval = setInterval(() => {
        if (examSubmitted) {
          clearInterval(interval);
          return;
        }

        let hours = Math.floor(timer / 3600);
        let minutes = Math.floor((timer % 3600) / 60);
        let seconds = timer % 60;

        display.textContent =
          (hours < 10 ? "0" + hours : hours) + ":" +
          (minutes < 10 ? "0" + minutes : minutes) + ":" +
          (seconds < 10 ? "0" + seconds : seconds);

        if (--timer < 0) {
          clearInterval(interval);
          submitExam();
        }

        // ✅ Extra check: if current time > exam_end, force exit
        const now = Date.now();
        if (now > examEndTimestamp) {
          clearInterval(interval);
          alert("⏰ Exam time expired!");
          window.location.href = "index.php?msg=exam_expired";
        }

      }, 1000);
    }

    window.onload = function () {
      if (questions.length > 0) {
        loadQuestion();
        const display = document.getElementById("exam-timer");
        startCountdown(examTimeInSeconds, display);
      } else {
        document.getElementById("question-text").innerText = "No questions available.";
      }
    };
  </script>

</body>
</html>
