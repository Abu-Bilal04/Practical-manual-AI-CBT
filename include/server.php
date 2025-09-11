<?php
session_start();
include 'db_connection.php';



if (isset($_POST['login'])) {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  
       $check_user = "SELECT * FROM admin WHERE username = '$username' AND password='$password'";
       $run = mysqli_query($dbcon,$check_user);
       if (mysqli_num_rows($run)>0) {
        $_SESSION['username'] = $username;
          echo "<script>window.open('index.php','_self')</script>";
        }else{
         echo "<script>window.open('login.php?msg=error','_self')</script>";
      } 
}

//for session
if (isset($_POST['register_session'])) {
    $session_year = trim($_POST['session_year']);

    // Convert entered year into session format "previous/current"
    if (is_numeric($session_year) && strlen($session_year) == 4) {
        $prev_year = $session_year - 1;
        $session_year = $prev_year . "/" . $session_year;
    }

    // Check if session already exists
    $check = "SELECT * FROM session WHERE session = '$session_year'";
    $result = mysqli_query($dbcon, $check);

    if (mysqli_num_rows($result) > 0) {
        // Session already exists
        echo "<script>window.open('manage_session.php?msg=exists','_self');</script>";
    } else {
        // Insert new session
        $sql = "INSERT INTO session (session) VALUES ('$session_year')";
        if (mysqli_query($dbcon, $sql)) {
            echo "<script>window.open('manage_session.php?msg=success','_self');</script>";
        } else {
            echo "<script>window.open('manage_session.php?msg=error','_self');</script>";
        }
    }
}


//for level
if (isset($_POST['register_level'])) {
    $level_name = trim($_POST['level_name']);

    // Check if level already exists
    $check = "SELECT * FROM level WHERE level = '$level_name'";
    $result = mysqli_query($dbcon, $check);

    if (mysqli_num_rows($result) > 0) {
        // Level already exists
        echo "<script>window.open('manage_level.php?msg=exists','_self');</script>";
    } else {
        // Insert new level
        $sql = "INSERT INTO level (level) VALUES ('$level_name')";
        if (mysqli_query($dbcon, $sql)) {
            echo "<script>window.open('manage_level.php?msg=success','_self');</script>";
        } else {
            echo "<script>window.open('manage_level.php?msg=error','_self');</script>";
        }
    }
}

if (isset($_POST['register_course'])) {
    $level_id = intval($_POST['level_id']);
    $course_code = trim($_POST['course_code']);
    $course_title = trim($_POST['course_title']);

    // Check if course code already exists for this level
    $check_sql = "SELECT * FROM course WHERE course_code = '$course_code' AND level_id = '$level_id'";
    $check_result = mysqli_query($dbcon, $check_sql);

    if (!$check_result) {
        die("MySQL error: " . mysqli_error($dbcon));
    }

    if (mysqli_num_rows($check_result) > 0) {
        // Course code exists → do not save
        echo "<script>window.open('register_course.php?msg=exists','_self');</script>";
    } else {
        // Insert new course
        $insert_sql = "INSERT INTO course (level_id, course_code, course_title)
                       VALUES ('$level_id', '$course_code', '$course_title')";
        if (mysqli_query($dbcon, $insert_sql)) {
            echo "<script>window.open('register_course.php?msg=success','_self');</script>";
        } else {
            die("MySQL error: " . mysqli_error($dbcon));
        }
    }
}

//register student
if (isset($_POST['register_student'])) {
    $fullname = trim(mysqli_real_escape_string($dbcon, $_POST['fullname']));
    $regno = trim(mysqli_real_escape_string($dbcon, $_POST['regno']));
    $password = $regno;
    $level_id = intval($_POST['level_id']);

    // Check for empty fields
    if (empty($fullname) || empty($regno) || empty($level_id)) {
        echo "<script>window.open('register_student.php?msg=empty','_self');</script>";
    } else {
        // Check if regno already exists
        $check = "SELECT * FROM student WHERE regno = '$regno' AND level_id = '$level_id'";
        $result = mysqli_query($dbcon, $check);

        if (mysqli_num_rows($result) > 0) {
        echo "<script>window.open('register_student.php?msg=exists','_self');</script>";
        } else {
            // Insert student
            $insert = "INSERT INTO student (fullname, regno, password, level_id) VALUES ('$fullname', '$regno', '$password', '$level_id')";
            if (mysqli_query($dbcon, $insert)) {
                echo "<script>window.open('register_student.php?msg=success','_self');</script>";
            } else {
                echo "<script>window.open('register_student.php?msg=error','_self');</script>";
            }
        }
    }
}



// student login
if (isset($_POST['student_login'])) {
  $regno = trim($_POST['regno']);
  $password = trim($_POST['password']);

  
       $check_user = "SELECT * FROM student WHERE regno = '$regno' AND password='$password'";
       $run = mysqli_query($dbcon,$check_user);
       if (mysqli_num_rows($run)>0) {
        $_SESSION['regno'] = $regno;
          echo "<script>window.open('student/index.php','_self')</script>";
        }else{
         echo "<script>window.open('login.php?msg=error','_self')</script>";
      } 
}

?>
