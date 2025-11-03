<?php
include "../include/server.php";
session_start();

// Check admin login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Handle delete action
if (isset($_GET['delete_course_id'])) {
    $course_id = intval($_GET['delete_course_id']);
    $del_sql = "DELETE FROM questions WHERE course_id = ?";
    $stmt = $dbcon->prepare($del_sql);
    $stmt->bind_param("i", $course_id);
    if ($stmt->execute()) {
        echo "<script>window.location='questions.php?msg=deleted';</script>";
        exit();
    } else {
        echo "Error deleting questions: " . $dbcon->error;
    }
}

// Fetch courses with question count
$sql = "SELECT c.id, c.course_code, c.course_title, COUNT(q.id) AS question_count
        FROM course c
        LEFT JOIN questions q ON c.id = q.course_id
        GROUP BY c.id
        ORDER BY c.course_title ASC";
$result = mysqli_query($dbcon, $sql);
?>
<!doctype html>
<html lang="en" data-pc-theme="light">
<head>
  <meta charset="UTF-8">
  <title>Questions || Practical Manual System</title>
  <link rel="stylesheet" href="../dist/assets/css/style.css" />
  <link rel="stylesheet" href="../bootstrap-icons/bootstrap-icons.css">
  <!-- Bootstrap for Modal -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <li class="dropdown pc-h-item">
          <a class="pc-head-link dropdown-toggle me-0" data-pc-toggle="dropdown" href="#" role="button"
            aria-haspopup="false" aria-expanded="false">
            <i data-feather="search"></i>
          </a>
          <div class="dropdown-menu pc-h-dropdown drp-search">
            <form class="px-2 py-1">
              <input type="search" class="form-control !border-0 !shadow-none" placeholder="Search here. . ." />
            </form>
          </div>
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
        <li class="pc-item pc-caption">
        </li>
        <li class="pc-item">
          <a href="index.php" class="pc-link">
            <span class="pc-micon">
              <i data-feather="home"></i>
            </span>
            <span class="pc-mtext">Dashboard</span>
          </a>
        </li>
        <li class="pc-item pc-caption">
          <label>Navigations</label>
          <i data-feather="feather"></i>
        </li>
        <li class="pc-item pc-hasmenu">
          <a href="manage_session.php" class="pc-link">
            <span class="pc-micon"> <i class="bi bi-calendar-check"></i></span>
            <span class="pc-mtext">Manage sessions</span>
          </a>
        </li>
        <li class="pc-item pc-hasmenu">
          <a href="manage_level.php" class="pc-link">
            <span class="pc-micon"> <i class="bi bi-layers"></i></span>
            <span class="pc-mtext">Manage levels</span>
          </a>
        </li>
        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link">
            <span class="pc-micon"> <i class="bi bi-book"></i></span>
            <span class="pc-mtext">Courses</span>
            <span class="pc-arrow"><i class="bi bi-caret-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="register_course.php"><i class="bi bi-person-plus"></i> Register</a></li>
            <li class="pc-item"><a class="pc-link" href="view_course.php"><i class="bi bi-person-lines-fill"></i> Manage</a></li>
          </ul>
        </li>
        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link">
            <span class="pc-micon"> <i class="bi bi-people"></i></span>
            <span class="pc-mtext">Students</span>
            <span class="pc-arrow"><i class="bi bi-caret-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="register_student.php"><i class="bi bi-person-plus"></i> Register</a></li>
            <li class="pc-item"><a class="pc-link" href="view_student.php"><i class="bi bi-person-lines-fill"></i> View</a></li>
          </ul>
        </li>
        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link">
            <span class="pc-micon"> <i class="bi bi-journal-text"></i></span>
            <span class="pc-mtext">Manuals</span>
            <span class="pc-arrow"><i class="bi bi-caret-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="set_question.php"><i class="bi bi-pencil-square"></i> Set question</a></li>
            <li class="pc-item"><a class="pc-link" href="questions.php"><i class="bi bi-book"></i> View manuals</a></li>
          </ul>
        </li>
        <li class="pc-item pc-hasmenu">
          <a href="results.php" class="pc-link">
            <span class="pc-micon"> <i class="bi bi-clipboard-data"></i></span>
            <span class="pc-mtext">Results</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- MAIN CONTENT -->
<div class="pc-container" style="margin-left:250px;">
  <div class="pc-content" style="padding-top: 0px;">

    <div class="page-header">
      <div class="page-block">
        <div class="page-header-title">
          <h5 class="mb-0 font-medium">Manage Questions</h5>
        </div>
        <ul class="breadcrumb">
          <li><a href="index.php">Home</a></li>
          <i class="bi bi-arrow-right-circle"></i>
          <li>Questions</li>
        </ul>
      </div>
    </div>

    <div class="card p-4">
      
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Course Code</th>
              <th>Course Title</th>
              <th>No. of Questions</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
              <?php $sn = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td><?= $sn++ ?></td>
                  <td><?= htmlspecialchars($row['course_code']) ?></td>
                  <td><?= htmlspecialchars($row['course_title']) ?></td>
                  <td><?= intval($row['question_count']) ?></td>
                  <td>
                    <a href="questions.php?delete_course_id=<?= $row['id'] ?>" 
                      onclick="return confirm('Are you sure you want to delete all questions for <?= htmlspecialchars($row['course_title']) ?>?');" 
                      class="btn btn-sm btn-danger">
                      Delete
                    </a>
                    <?php
                    // Handle delete via GET
                    if (isset($_GET['delete_course_id'])) {
                        $course_id = intval($_GET['delete_course_id']);
                        $del_sql = "DELETE FROM questions WHERE course_id = ?";
                        $stmt = $dbcon->prepare($del_sql);
                        $stmt->bind_param("i", $course_id);
                        if ($stmt->execute()) {
                            echo "<script>window.location='questions.php?msg=deleted';</script>";
                            exit();
                        } else {
                            echo "Error deleting questions: " . $dbcon->error;
                        }
                    }
                    ?>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center">No courses found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="viewQuestionsModal" tabindex="-1" aria-labelledby="viewQuestionsLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="viewQuestionsLabel">Questions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="modalContent">Loading questions...</div>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const viewButtons = document.querySelectorAll('.view-btn');
  const modalContent = document.getElementById('modalContent');
  const modalTitle = document.getElementById('viewQuestionsLabel');
  const viewModal = new bootstrap.Modal(document.getElementById('viewQuestionsModal'));

  viewButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      const courseId = btn.getAttribute('data-course-id');
      const courseName = btn.getAttribute('data-course-name');
      modalTitle.textContent = "Questions for " + courseName;
      modalContent.innerHTML = 'Loading questions...';

      fetch('fetch_questions.php?course_id=' + courseId)
        .then(res => res.json())
        .then(data => {
          if (data.length === 0) {
            modalContent.innerHTML = '<p>No questions found for this course.</p>';
            return;
          }

          let html = '<table class="table table-bordered"><thead><tr><th>#</th><th>Question</th><th>Correct Answer</th></tr></thead><tbody>';
          data.forEach((q, index) => {
            html += `<tr>
                       <td>${index+1}</td>
                       <td>${q.question_text}</td>
                       <td>${q.correct_answer}</td>
                     </tr>`;
          });
          html += '</tbody></table>';
          modalContent.innerHTML = html;
        })
        .catch(err => {
          modalContent.innerHTML = '<p class="text-danger">Error loading questions.</p>';
          console.error(err);
        });

      viewModal.show();
    });
  });
});
</script>
</body>
</html>
