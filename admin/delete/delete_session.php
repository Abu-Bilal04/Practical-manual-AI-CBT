<?php
include("../../include/db_connection.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // make sure id is safe

    // Delete query
    $sql = "DELETE FROM session WHERE id = $id";
    if (mysqli_query($dbcon, $sql)) {
        // Redirect back with success message
        header("Location: ../manage_session.php?msg=deleted");
        exit();
    } else {
        // Redirect back with error message
        header("Location: ../manage_session.php?msg=error");
        exit();
    }
} else {
    // No id provided
    header("Location: ../manage_session.php?msg=invalid");
    exit();
}
?>
