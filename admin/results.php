<?php
include "../include/server.php";
session_start();

// ✅ Check admin login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// ✅ Fetch exam results with correct column names
$sql = "
  SELECT 
    er.id,
    s.fullname,
    s.regno,
    c.course_code,
    c.course_title,
    er.score,
    er.total_questions,
    er.correct_answers,
    er.exam_date
  FROM exam_results er
  INNER JOIN student s ON er.student_id = s.id
  INNER JOIN course c ON er.course_id = c.id
  ORDER BY er.exam_date DESC
";
$result = mysqli_query($dbcon, $sql);
?>
<!doctype html>
<html lang="en" data-pc-theme="light">
<head>
  <meta charset="UTF-8">
  <title>Exam Results || Practical Manual System</title>
  <link rel="stylesheet" href="../dist/assets/css/style.css" />
  <link rel="stylesheet" href="../bootstrap-icons/bootstrap-icons.css">
  <style>
    /* Ensure content is not hidden behind the sidebar */
    .pc-content {
        margin-left: 260px; /* Adjust according to your sidebar width */
        transition: margin-left 0.3s;
    }
    @media (max-width: 1024px) {
        .pc-content {
            margin-left: 0;
        }
    }
    th {
      background-color: #2563eb;
      color: white;
      text-align: center;
    }
    td {
      text-align: center;
    }
  </style>
</head>
<body>

<!-- HEADER -->
<header class="pc-header">
  <div class="header-wrapper flex max-sm:px-[15px] px-[25px] grow">
    <div class="me-auto pc-mob-drp">
      <ul class="inline-flex *:min-h-header-height *:inline-flex *:items-center">
        <li class="pc-h-item pc-sidebar-collapse max-lg:hidden lg:inline-flex">
          <a href="#" class="pc-head-link ltr:!ml-0 rtl:!mr-0" id="sidebar-hide">
            <i data-feather="menu"></i>
          </a>
        </li>
        <li class="pc-h-item pc-sidebar-popup lg:hidden">
          <a href="#" class="pc-head-link ltr:!ml-0 rtl:!mr-0" id="mobile-collapse">
            <i data-feather="menu"></i>
          </a>
        </li>
      </ul>
    </div>

    <div class="ms-auto">
      <ul class="inline-flex *:min-h-header-height *:inline-flex *:items-center">
        <li class="dropdown pc-h-item header-user-profile">
          <a class="pc-head-link dropdown-toggle arrow-none me-0" data-pc-toggle="dropdown" href="#" role="button"
            aria-haspopup="false" data-pc-auto-close="outside" aria-expanded="false">
            <i data-feather="user"></i>
          </a>
          <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown p-2 overflow-hidden">
            <div class="dropdown-header flex items-center justify-between py-4 px-5 bg-primary-500">
              <div class="flex mb-1 items-center">
                <div class="shrink-0">
                  <img src="../dist/assets/images/user/avatar-2.jpg" alt="user-image" class="w-10 rounded-full" />
                </div>
                <div class="grow ms-3">
                  <h6 class="mb-1 text-white"><?= htmlspecialchars($_SESSION['username']); ?></h6>
                  <span class="text-white">Admin</span>
                </div>
              </div>
            </div>
            <div class="dropdown-body py- px-5">
              <div class="profile-notification-scroll position-relative" style="max-height: calc(100vh - 225px)">
                <a href="logout.php" style="cursor: pointer;" class="btn btn-danger flex items-center justify-center w-full">
                  <svg class="pc-icon me-2 w-[22px] h-[22px]">
                    <use xlink:href="#custom-logout-1-outline"></use>
                  </svg>
                  Logout
                </a>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</header>

<!-- SIDEBAR -->
<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header flex items-center py-4 px-6 h-header-height">
      <a href="index.php" class="b-brand flex items-center gap-3">
        <center>
          <img src="../dist/assets/images/logo/logo.png" width="50%" alt="">
        </center>
      </a>
    </div>
    <div class="navbar-content h-[calc(100vh_-_74px)] py-2.5">
      <ul class="pc-navbar">
        <li class="pc-item"><a href="index.php" class="pc-link"><i data-feather="home"></i><span>Dashboard</span></a></li>
        <li class="pc-item"><a href="manage_session.php" class="pc-link"><i class="bi bi-calendar-check"></i> Manage Sessions</a></li>
        <li class="pc-item"><a href="manage_level.php" class="pc-link"><i class="bi bi-layers"></i> Manage Levels</a></li>
        <li class="pc-item"><a href="register_course.php" class="pc-link"><i class="bi bi-book"></i> Courses</a></li>
        <li class="pc-item"><a href="register_student.php" class="pc-link"><i class="bi bi-people"></i> Students</a></li>
        <li class="pc-item"><a href="set_question.php" class="pc-link"><i class="bi bi-journal-text"></i> Manuals</a></li>
        <li class="pc-item active"><a href="results.php" class="pc-link"><i class="bi bi-clipboard-data"></i> Results</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- MAIN CONTENT -->
<div class="pc-container">
  <div class="pc-content">
    <div class="page-header">
      <div class="page-block">
        <div class="page-header-title">
          <h5 class="mb-0 font-medium">Exam Results</h5>
        </div>
        <ul class="breadcrumb">
          <li><a href="index.php">Home</a></li>
          <i class="bi bi-arrow-right-circle"></i>
          <li>Results</li>
        </ul>
      </div>
    </div>

    <!-- ✅ Results Table -->
    <div class="card p-4 overflow-x-auto">
      <table class="table table-striped table-bordered w-full">
        <thead>
          <tr>
            <th>#</th>
            <th>Student Name</th>
            <th>Reg No</th>
            <th>Course</th>
            <th>Score (%)</th>
            <th>Total Questions</th>
            <th>Correct Answers</th>
            <th>Exam Date</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($result) > 0): ?>
            <?php $sn = 1; while ($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?= $sn++ ?></td>
                <td><?= htmlspecialchars($row['fullname']) ?></td>
                <td><?= htmlspecialchars($row['regno']) ?></td>
                <td><?= htmlspecialchars($row['course_code'] . " - " . $row['course_title']) ?></td>
                <td><?= htmlspecialchars($row['score']) ?></td>
                <td><?= htmlspecialchars($row['total_questions']) ?></td>
                <td><?= htmlspecialchars($row['correct_answers']) ?></td>
                <td><?= date("Y-m-d H:i", strtotime($row['exam_date'])) ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" class="text-center text-gray-500">No results found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

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
