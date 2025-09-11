<?php
include("../../include/db_connection.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // sanitize id

    // Delete query (correct table name)
    $sql = "DELETE FROM level WHERE id = $id";
    if (mysqli_query($dbcon, $sql)) {
        // Redirect back with success message
        header("Location: ../manage_level.php?msg=deleted");
        exit();
    } else {
        // Redirect back with error message
        header("Location: ../manage_level.php?msg=error");
        exit();
    }
} else {
    // No id provided
    header("Location: ../manage_level.php?msg=invalid");
    exit();
}
?>
