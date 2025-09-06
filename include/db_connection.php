
<?php

$dbcon = mysqli_connect("localhost", "root", "") or die("Could not connect database");
mysqli_select_db($dbcon, 'projecttopics') or die("Could not select database");

?>