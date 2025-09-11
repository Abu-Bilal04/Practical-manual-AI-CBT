<?php  
session_start(); 
$f=0;
if (isset($_SESSION["fullname"]) || isset($_SESSION["regno"])) {
    $f = 1;
} else {
    $f = 0;
}
session_destroy(); 

 if($f==0)
 {
?>
<script>
window.location="../index.php";
</script>
<?php
}
if($f==1)
 {
?>
<script>
window.location="../index.php";
</script>
<?php
}
  exit;
?>