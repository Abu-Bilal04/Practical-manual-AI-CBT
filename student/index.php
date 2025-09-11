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

    if (empty($new_password)) {
        die("Password cannot be empty.");
    }

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
<?php
// ✅ Get distinct exam schedules
$sql = "SELECT q.exam_schedule, q.exam_time
        FROM questions q
        GROUP BY q.exam_schedule, q.exam_time
        ORDER BY q.exam_schedule ASC";

$result = mysqli_query($dbcon, $sql);
$exams = [];
while ($row = mysqli_fetch_assoc($result)) {
    $exams[] = $row;
}

// set timezone
date_default_timezone_set("Africa/Lagos");
?>

<div class="grid grid-cols-12 gap-6">
<?php foreach ($exams as $index => $exam): 
  $exam_schedule = $exam['exam_schedule'];
  $exam_time     = $exam['exam_time'];

  $now = new DateTime();
  $exam_start = new DateTime($exam_schedule);
  $exam_end   = clone $exam_start;
  $exam_end->modify("+{$exam_time} minutes");
  $exam_hide  = clone $exam_end;
  $exam_hide->modify("+2 hours");

  if ($now > $exam_hide) continue;

  if ($now < $exam_start) {
      $status = "upcoming";
      $seconds_left = $exam_start->getTimestamp() - $now->getTimestamp();
  } elseif ($now >= $exam_start && $now <= $exam_end) {
      $status = "ongoing";
  } elseif ($now > $exam_end && $now <= $exam_hide) {
      $status = "passed";
  } else {
      continue;
  }
?>
  <div class="col-span-12 sm:col-span-6 lg:col-span-4 xl:col-span-3">
    <div class="card h-full flex flex-col justify-between">
      <div class="card-header !pb-0 !border-b-0">
        <h5 class="text-base sm:text-lg font-semibold">
          Exam on <?= htmlspecialchars($exam_schedule) ?>
        </h5>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <h6 class="font-medium text-gray-700 text-sm sm:text-base">
            Duration: <?= htmlspecialchars($exam_time) ?> minutes
          </h6>
        </div>
        <div class="mb-3 flex items-center gap-2 flex-wrap">
          <i class="bi bi-clock text-primary"></i>
          <?php if ($status === "upcoming"): ?>
            <span id="countdown-<?= $index ?>" class="text-sm sm:text-base">Loading...</span>
            <script>startCountdown("countdown-<?= $index ?>", <?= $seconds_left ?>);</script>
          <?php elseif ($status === "ongoing"): ?>
            <span class="badge bg-warning text-dark text-sm">Ongoing</span>
          <?php else: ?>
            <span class="badge bg-secondary text-sm">Finished</span>
          <?php endif; ?>
        </div>
        <div class="text-center">
          <?php if ($status === "upcoming"): ?>
            <button class="btn btn-secondary w-full text-sm sm:text-base" disabled>Not Started</button>
          <?php elseif ($status === "ongoing"): ?>
            <a href="take_exam.php?exam_schedule=<?= urlencode($exam_schedule) ?>" 
               class="btn btn-primary w-full text-sm sm:text-base">Take Test</a>
          <?php else: ?>
            <button class="btn btn-dark w-full text-sm sm:text-base" disabled>Closed</button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>

</div>

<script>
function startCountdown(elementId, durationInSeconds) {
  let timer = durationInSeconds;
  const countdownElement = document.getElementById(elementId);

  const interval = setInterval(() => {
    let hours = Math.floor(timer / 3600);
    let minutes = Math.floor((timer % 3600) / 60);
    let seconds = timer % 60;

    countdownElement.textContent =
      `${hours.toString().padStart(2, '0')}:` +
      `${minutes.toString().padStart(2, '0')}:` +
      `${seconds.toString().padStart(2, '0')}`;

    if (--timer < 0) {
      clearInterval(interval);
      countdownElement.textContent = "Time's up!";
    }
  }, 1000);
}
</script>

  </div>
</div>


<script src="../dist/assets/js/plugins/simplebar.min.js"></script>
<script src="../dist/assets/js/plugins/popper.min.js"></script>
<script src="../dist/assets/js/icon/custom-icon.js"></script>
<script src="../dist/assets/js/plugins/feather.min.js"></script>
<script src="../dist/assets/js/component.js"></script>
<script src="../dist/assets/js/theme.js"></script>
<script src="../dist/assets/js/script.js"></script>
</body>
</html>
