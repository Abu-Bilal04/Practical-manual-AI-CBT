<?php
include "../include/server.php";
session_start();

// Redirect if user not logged in (username required)
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header('Location: logout.php');
    exit();
}

$userusername = $_SESSION['username'];
?>
<!doctype html>
<html lang="en" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" dir="ltr" data-pc-theme="light">
<head>
    <title>Dashboard || Practical manual system</title>
    <link rel="icon" href="../dist/assets/images/logo/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="../dist/assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="../bootstrap-icons/bootstrap-icons.css">

  <!-- iziToast -->
  <link href="../iziToast/css/iziToast.min.css" rel="stylesheet" />
  <script src="../iziToast/js/iziToast.min.js" type="text/javascript"></script>
</head>
<body>

  <?php if (isset($_GET['msg']) && $_GET['msg'] == "update") { ?>
  <script>
    iziToast.success({
      title: '',
      message: 'Password uploaded successfully',
      position: 'topRight',
      animateInside: true
    });
  </script>
  <?php } ?>

   <?php if (isset($_GET['msg']) && $_GET['msg'] == "success") { ?>
  <script>
    iziToast.success({
      title: '',
      message: 'Questions saved successfully',
      position: 'topRight',
      animateInside: true
    });
  </script>
  <?php } ?>
  
<?php
// ----------------- Handle Save Exam -----------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_exam'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (!isset($dbcon)) {
        die("Database connection not available.");
    }

    $session_id    = intval($_POST['session_id']);
    $level_id      = intval($_POST['level_id']);
    $course_id     = intval($_POST['course_id']);
    $exam_time     = mysqli_real_escape_string($dbcon, $_POST['exam_time']);
    $exam_schedule = mysqli_real_escape_string($dbcon, $_POST['exam_schedule']);

    if ($session_id <= 0 || $level_id <= 0 || $course_id <= 0) {
        die("Missing exam setup values. Check hidden inputs.");
    }

    if (!empty($_POST['questions'])) {
        foreach ($_POST['questions'] as $idx => $q) {
            if (!isset($q['text'], $q['option_a'], $q['option_b'], $q['option_c'], $q['option_d'], $q['correct'])) {
                die("Missing values in question #$idx");
            }

            $question_text = mysqli_real_escape_string($dbcon, $q['text']);
            $opt_a         = mysqli_real_escape_string($dbcon, $q['option_a']);
            $opt_b         = mysqli_real_escape_string($dbcon, $q['option_b']);
            $opt_c         = mysqli_real_escape_string($dbcon, $q['option_c']);
            $opt_d         = mysqli_real_escape_string($dbcon, $q['option_d']);
            $correct       = mysqli_real_escape_string($dbcon, $q['correct']);

            $sql_question = "INSERT INTO questions (session_id, level_id, course_id, question_text, exam_time, exam_schedule) 
                             VALUES ('$session_id', '$level_id', '$course_id', '$question_text', '$exam_time', '$exam_schedule')";
            if (mysqli_query($dbcon, $sql_question)) {
                $question_id = mysqli_insert_id($dbcon);

                $sql_answer = "INSERT INTO answer (question_id, opt_a, opt_b, opt_c, opt_d, correct_option) 
                               VALUES ('$question_id', '$opt_a', '$opt_b', '$opt_c', '$opt_d', '$correct')";
                if (!mysqli_query($dbcon, $sql_answer)) {
                    die("Error saving answers: " . mysqli_error($dbcon));
                }
            } else {
                die("Error saving question: " . mysqli_error($dbcon));
            }
        }
        echo "<script>window.open('set_question.php?msg=success','_self');</script>";
        exit();
    } else {
        die("No questions submitted.");
    }
}

// ----------------- Handle Proceed -----------------
$session_id    = isset($_POST['session_id']) ? intval($_POST['session_id']) : 0;
$level_id      = isset($_POST['level_id']) ? intval($_POST['level_id']) : 0;
$course_id     = isset($_POST['course_id']) ? intval($_POST['course_id']) : 0;
$exam_time     = isset($_POST['exam_time']) ? $_POST['exam_time'] : "";
$exam_schedule = isset($_POST['exam_schedule']) ? $_POST['exam_schedule'] : "";
$num_questions = isset($_POST['num_questions']) ? intval($_POST['num_questions']) : 0;
?>

<!-- Your Sidebar & Header (unchanged for brevity) -->
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
<!--<li class="dropdown pc-h-item">
      <a class="pc-head-link dropdown-toggle me-0" data-pc-toggle="dropdown" href="#" role="button"
        aria-haspopup="false" aria-expanded="false">
        <i data-feather="sun"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
        <a href="#!" class="dropdown-item" onclick="layout_change('dark')">
          <i data-feather="moon"></i>
          <span>Dark</span>
        </a>
        <a href="#!" class="dropdown-item" onclick="layout_change('light')">
          <i data-feather="sun"></i>
          <span>Light</span>
        </a>
        
      </div>
    </li> -->
   
    
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
              <h6 class="mb-1 text-white">Muhammad Ibrahim Musa</h6>
              <span class="text-white">Admin</span>
            </div>
          </div>
        </div>
        <div class="dropdown-body py- px-5">
          <div class="profile-notification-scroll position-relative" style="max-height: calc(100vh - 225px)">
            <a href="#" class="dropdown-item">
              <form method="post">
                <span>
                  <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>
                </span>
                <center>
                  <button type="submit" name="change_password" class="mt-2 btn btn-primary">Change Password</button>
                </center>
              </form>
              <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
                    $new_password = trim($_POST['new_password']);

                    if (empty($new_password)) {
                        die("Password cannot be empty.");
                    }

                    // Get logged-in admin ID from session
                    $admin_id = $_SESSION['admin_id'] ?? 1; // fallback to admin ID 1

                    // Update password directly (NO HASH)
                    $sql = "UPDATE admin SET password = ? WHERE id = ?";
                    $stmt = $dbcon->prepare($sql);
                    $stmt->bind_param("si", $new_password, $admin_id);

                    if ($stmt->execute()) {
                        echo "<script>window.open('set_question.php?msg=update', '_self');</script>";
                    } else {
                        echo "Error updating password: " . $dbcon->error;
                    }
                }
                ?>
            <div class="grid my-3">
              <a href="logout.php" style="cursor: pointer;" class="btn btn-danger flex items-center justify-center">
                <svg class="pc-icon me-2 w-[22px] h-[22px]">
                  <use xlink:href="#custom-logout-1-outline"></use>
                </svg>
                Logout
              </a>
            </div>
          </div>
        </div>
      </div>
    </li>
  </ul>
</div></div>
</header>

<div class="pc-container">
  <div class="pc-content">
    <div class="page-header">
      <div class="page-block">
        <div class="page-header-title">
          <h5 class="mb-0 font-medium">Set question</h5>
        </div>
      </div>
    </div>

    <div class="grid">
      <div class="col-span-12">
        <div class="card">
          <div class="card-header">
            <h5>Set question</h5>
          </div>
          <div class="card-body">

          <!-- Step 1: Exam Setup -->
          <form method="post">
              <div class="card">
                  <div class="card-header"><h5>Setup Exam</h5></div>
                  <div class="card-body">
                      <!-- Session -->
                      <select name="session_id" class="form-control mb-3" required>
                          <option value="">--Select session--</option>
                          <?php
                          $sql = "SELECT * FROM session ORDER BY id ASC";
                          $result = mysqli_query($dbcon, $sql);
                          while ($row = mysqli_fetch_assoc($result)) {
                              echo "<option value='" . $row['id'] . "'>" . $row['session'] . "</option>";
                          }
                          ?>
                      </select>

                      <!-- Level -->
                      <select name="level_id" class="form-control mb-3" required>
                          <option value="">--Select level--</option>
                          <?php
                          $sql = "SELECT * FROM level ORDER BY id ASC";
                          $result = mysqli_query($dbcon, $sql);
                          while ($row = mysqli_fetch_assoc($result)) {
                              echo "<option value='" . $row['id'] . "'>" . $row['level'] . "</option>";
                          }
                          ?>
                      </select>

                      <!-- Course -->
                      <select name="course_id" class="form-control mb-3" required>
                          <option value="">--Select course--</option>
                          <?php
                          $sql = "SELECT * FROM course ORDER BY id ASC";
                          $result = mysqli_query($dbcon, $sql);
                          while ($row = mysqli_fetch_assoc($result)) {
                              echo "<option value='" . $row['id'] . "'>" . $row['course_code'] . "</option>";
                          }
                          ?>
                      </select>

                      <input type="number" name="num_questions" class="form-control mb-3" placeholder="Number of Questions" required />
                      <input type="text" name="exam_time" class="form-control mb-3" placeholder="Exam Time (mins)" required />
                      <input type="datetime-local" name="exam_schedule" class="form-control mb-3" required />
                      <button type="submit" name="proceed" class="btn btn-primary">Proceed</button>
                  </div>
              </div>
          </form>

          <!-- Step 2: Questions Form -->
          <?php if ($num_questions > 0): ?>
          <form method="post" action="set_question.php">
              <input type="hidden" name="session_id" value="<?= htmlspecialchars($session_id) ?>">
              <input type="hidden" name="level_id" value="<?= htmlspecialchars($level_id) ?>">
              <input type="hidden" name="course_id" value="<?= htmlspecialchars($course_id) ?>">
              <input type="hidden" name="exam_time" value="<?= htmlspecialchars($exam_time) ?>">
              <input type="hidden" name="exam_schedule" value="<?= htmlspecialchars($exam_schedule) ?>">

              <div class="card mt-4">
                  <div class="card-header"><h5>Enter Questions</h5></div>
                  <div class="card-body">
                      <?php for ($i = 1; $i <= $num_questions; $i++): ?>
                          <div class="mb-4 p-3 border rounded">
                              <h6>Question <?= $i ?></h6>
                              <textarea name="questions[<?= $i ?>][text]" class="form-control mb-2" placeholder="Enter question text" required></textarea>

                              <input type="text" name="questions[<?= $i ?>][option_a]" class="form-control mb-2" placeholder="Option A" required />
                              <input type="text" name="questions[<?= $i ?>][option_b]" class="form-control mb-2" placeholder="Option B" required />
                              <input type="text" name="questions[<?= $i ?>][option_c]" class="form-control mb-2" placeholder="Option C" required />
                              <input type="text" name="questions[<?= $i ?>][option_d]" class="form-control mb-2" placeholder="Option D" required />

                              <select name="questions[<?= $i ?>][correct]" class="form-control" required>
                                  <option value="">--Correct Answer--</option>
                                  <option value="A">Option A</option>
                                  <option value="B">Option B</option>
                                  <option value="C">Option C</option>
                                  <option value="D">Option D</option>
                              </select>
                          </div>
                      <?php endfor; ?>
                      <button type="submit" name="save_exam" class="btn btn-success">Save Exam</button>
                  </div>
              </div>
          </form>
          <?php endif; ?>

          </div>
        </div>
      </div>
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
