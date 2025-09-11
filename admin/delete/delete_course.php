<?php
include("../../include/db_connection.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // ensure numeric

    if ($id > 0) {
        $sql = "DELETE FROM course WHERE id = $id";
        if (mysqli_query($dbcon, $sql)) {
            header("Location: ../view_course.php?msg=deleted");
            exit();
        } else {
            die("Error deleting course: " . mysqli_error($dbcon));
        }
    } else {
        header("Location: ../view_course.php?msg=invalid");
        exit();
    }
} else {
    header("Location: ../view_course.php?msg=invalid");
    exit();
}
?>