<?php
// DB connection
include "../include/server.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check login
if (!isset($_SESSION['regno'])) {
    header("Location: logout.php");
    exit();
}

// Fetch student info
$regno = $_SESSION['regno'];
$sql = "SELECT id, fullname, regno FROM student WHERE regno = ?";
$stmt = $dbcon->prepare($sql);
$stmt->bind_param("s", $regno);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $new_password = trim($_POST['new_password']);
    if (empty($new_password)) die("Password cannot be empty.");
    $student_id = $student['id'];
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $sql = "UPDATE student SET password = ? WHERE id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->bind_param("si", $hashed_password, $student_id);

    if ($stmt->execute()) {
        echo "<script>window.open('index.php?msg=update', '_self');</script>";
        exit();
    } else {
        echo "Error updating password: " . $dbcon->error;
    }
}

// set timezone
date_default_timezone_set("Africa/Lagos");

// Fetch unique exam schedules
$sql = "SELECT DISTINCT exam_schedule, exam_time FROM questions ORDER BY exam_schedule ASC";
$result = mysqli_query($dbcon, $sql);
$schedules = [];
while ($row = mysqli_fetch_assoc($result)) {
    $schedules[] = $row;
}
?>
<!doctype html>
<html lang="en" data-pc-theme="light">
<head>
  <title>Dashboard || Practical manual system</title>
  <link rel="icon" href="../dist/assets/images/logo/logo.png" type="image/x-icon" />
  <link rel="stylesheet" href="../dist/assets/css/style.css" id="main-style-link" />
  <link rel="stylesheet" href="../bootstrap-icons/bootstrap-icons.css">
  <link href="../iziToast/css/iziToast.min.css" rel="stylesheet" />
  <script src="../iziToast/js/iziToast.min.js"></script>
</head>
<body>
<?php if (isset($_GET['msg']) && $_GET['msg'] == "update"): ?>
<script>
  iziToast.success({
    message: 'Password updated successfully',
    position: 'topRight'
  });
</script>
<?php endif; ?>

<!-- HEADER -->
<header class="pc-header">
  <div class="header-wrapper flex px-[15px] sm:px-[25px] grow">
    <div class="me-auto">
      <ul class="inline-flex items-center">
        <li class="pc-h-item pc-sidebar-collapse">
          <a href="#" class="pc-head-link" id="sidebar-hide"><i data-feather="menu"></i></a>
        </li>
      </ul>
    </div>
    <div class="ms-auto">
      <ul class="inline-flex items-center">
        <li class="dropdown pc-h-item header-user-profile">
          <a class="pc-head-link dropdown-toggle me-0" data-pc-toggle="dropdown" href="#">
            <i data-feather="user"></i>
          </a>
          <form method="post">
            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown p-2 overflow-hidden">
              <div class="dropdown-header flex items-center py-4 px-5 bg-primary-500">
                <div class="flex items-center">
                  <img src="../dist/assets/images/user/avatar-2.jpg" alt="user-image" class="w-10 rounded-full" />
                  <div class="ms-3">
                    <h6 class="text-white"><?= htmlspecialchars($student['fullname']); ?></h6>
                    <span class="text-white"><?= htmlspecialchars($student['regno']); ?></span>
                  </div>
                </div>
              </div>
              <div class="dropdown-body py-4 px-5">
                <span>
                  <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>
                </span>
                <center><button type="submit" name="change_password" class="mt-2 btn btn-primary">Change Password</button></center>
                <div class="grid my-3">
                  <a href="logout.php" class="btn btn-danger flex items-center justify-center">Logout</a>
                </div>
              </div>
            </div>
          </form>
        </li>
      </ul>
    </div>
  </div>
</header>

<!-- CONTENT -->
<div class="pc-container">
  <div class="pc-content">
    <div class="page-header">
      <div class="page-block">
        <div class="page-header-title">
          <h5 class="mb-0 font-medium">Dashboard</h5>
        </div>
        <ul class="breadcrumb">
          <li><a href="index.php">Home</a></li>
          <i class="bi bi-arrow-right-circle"></i>
          <li><a href="index.php">Dashboard</a></li>
        </ul>
      </div>
    </div>

<div class="grid grid-cols-12 gap-6">
<?php foreach ($schedules as $index => $scheduleRow): 
    $exam_schedule = $scheduleRow['exam_schedule'];
    $exam_time     = $scheduleRow['exam_time'];

    $now = new DateTime();
    $exam_start = new DateTime($exam_schedule);
    $exam_end   = clone $exam_start;
    $exam_end->modify("+{$exam_time} minutes");
    $exam_hide  = clone $exam_end;
    $exam_hide->modify("+2 hours");

    // Skip card if more than 2 hours past exam
    if ($now > $exam_hide) continue;

    // Determine status
    if ($now < $exam_start) {
        $status = "not_yet";
        $seconds_left = $exam_start->getTimestamp() - $now->getTimestamp();
    } elseif ($now >= $exam_start && $now <= $exam_hide) {
        $status = "take_exam";
    } else {
        continue;
    }

    // Fetch all courses/levels for this exam_schedule
    $sql_courses = "SELECT q.course_id, c.course_code, c.course_title, q.level_id
                    FROM questions q
                    JOIN course c ON q.course_id = c.id
                    WHERE q.exam_schedule = ? LIMIT 1";
    $stmt = $dbcon->prepare($sql_courses);
    $stmt->bind_param("s", $exam_schedule);
    $stmt->execute();
    $courses_result = $stmt->get_result();
    $courses = [];
    while ($course = $courses_result->fetch_assoc()) {
        $courses[] = $course;
    }

    // Format exam_schedule to 12-hour format
    $exam_display = date("Y-m-d h:ia", strtotime($exam_schedule));
?>
  <div class="col-span-12 sm:col-span-6 lg:col-span-4 xl:col-span-3">
    <div class="card h-full flex flex-col justify-between">
      <div class="card-header !pb-0 !border-b-0">
        <h5 class="text-base sm:text-lg font-semibold">
          Exam Schedule: <?= htmlspecialchars($exam_display) ?>
        </h5>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <?php foreach ($courses as $c): ?>
            <h6 class="font-medium text-gray-700 text-sm sm:text-base">
              <?= htmlspecialchars($c['course_code']) ?> - <?= htmlspecialchars($c['course_title']) ?> 
              (Level <?= htmlspecialchars($c['level_id']) ?>)
            </h6>
            <?php if ($status === "take_exam"): ?>
                <a href="ready.php?exam_schedule=<?= urlencode($exam_schedule) ?>&course_code=<?= urlencode($c['course_code']) ?>&level=<?= urlencode($c['level_id']) ?>" 
                   class="btn btn-primary w-full text-sm sm:text-base mb-2">
                   Take Exam
                </a>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>

        <div class="mb-3 flex items-center gap-2 flex-wrap">
          <i class="bi bi-clock text-primary"></i>
          <?php if ($status === "not_yet"): ?>
            <span id="countdown-<?= $index ?>" class="text-sm sm:text-base">Loading...</span>
            <script>
            startCountdown("countdown-<?= $index ?>", <?= $seconds_left ?>);
            </script>
          <?php elseif ($status === "take_exam"): ?>
            <span class="badge bg-success text-white text-sm">Time to Take Exam</span>
          <?php endif; ?>
        </div>

        <div class="text-center">
          <?php if ($status === "not_yet"): ?>
            <button class="btn btn-secondary w-full text-sm sm:text-base" disabled>Not Yet Time</button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>

<script>
function startCountdown(elementId, durationInSeconds) {
  let timer = durationInSeconds;
  const countdownElement = document.getElementById(elementId);
  if (!countdownElement) return;

  const interval = setInterval(() => {
    let hours = Math.floor(timer / 3600);
    let minutes = Math.floor((timer % 3600) / 60);
    let seconds = timer % 60;

    countdownElement.textContent =
      `${hours.toString().padStart(2,'0')}:` +
      `${minutes.toString().padStart(2,'0')}:` +
      `${seconds.toString().padStart(2,'0')}`;

    if (--timer < 0) {
      clearInterval(interval);
      countdownElement.textContent = "Time's up!";
      // Optionally refresh the page to show "Take Exam" button
      location.reload();
    }
  }, 1000);
}
</script>
<script>
// Fully prevent browser back navigation
(function () {
    // Push initial state
    history.pushState(null, null, location.href);

    // Trap any back/forward attempts
    window.onpopstate = function () {
        history.go(1);
    };

    // Optional: disable right-click + refresh shortcuts (F5, Ctrl+R)
    document.addEventListener("keydown", function (e) {
        if ((e.ctrlKey && e.key === "r") || e.key === "F5") {
            e.preventDefault();
            e.stopPropagation();
            alert("Refreshing is disabled during the exam.");
        }
    });

    document.addEventListener("contextmenu", function (e) {
        e.preventDefault();
    });
})();
</script>

<script src="../dist/assets/js/plugins/simplebar.min.js"></script>
<script src="../dist/assets/js/plugins/popper.min.js"></script>
<script src="../dist/assets/js/icon/custom-icon.js"></script>
<script src="../dist/assets/js/plugins/feather.min.js"></script>
<script src="../dist/assets/js/component.js"></script>
<script src="../dist/assets/js/theme.js"></script>
<script src="../dist/assets/js/script.js"></script>
</body>
</html>
