<?php
include "db_connection.php";
$id = isset($_GET['id']) ? trim($_GET['id']) : null;

if (isset($_POST['registertopic'])) {

 $studentname = trim($_POST['studentname']);
 $studentregno = trim($_POST['studentregno']);
 $studentlevel = trim($_POST['studentlevel']);
 $studentdate = trim($_POST['studentdate']);
 $studentsupervisor = trim($_POST['studentsupervisor']);
 $studenttopic = trim($_POST['studenttopic']);
 
// $topic = $_GET['studenttopic'];

 
if ($studentlevel == "ND") {
$checktopic = "SELECT * FROM  ndtopics WHERE studenttopic = '$studenttopic'";
$checkregno = "SELECT * FROM  ndtopics WHERE studentregno = '$studentregno'";
$realtopic = mysqli_query($dbcon,  $checktopic);
$realregno = mysqli_query($dbcon,  $checkregno);
$finalResultForTopic = mysqli_fetch_assoc($realtopic);
$finalResultForRegno = mysqli_fetch_assoc($realregno);
 if ($finalResultForTopic)
echo "<script>window.open('register.php?msg=topicExist','_self')</script>";

   elseif ($finalResultForRegno){
echo "<script>window.open('register.php?msg=regExist','_self')</script>";   }


 else{
    $insert = "INSERT INTO  ndtopics (studentname,studentregno,studentdate,studentsupervisor,studenttopic) 
   VALUES ('$studentname','$studentregno', '$studentdate','$studentsupervisor', '$studenttopic')";

  if (mysqli_query($dbcon,$insert)) {
         echo "<script>window.open('register.php?msg=success','_self')</script>";
  }
 }
 
}

elseif($studentlevel == "HND"){
$checktopic = "SELECT * FROM  hndtopics WHERE studenttopic = '$studenttopic'";
$checkregno = "SELECT * FROM  hndtopics WHERE studentregno = '$studentregno'";
$realtopic = mysqli_query($dbcon,  $checktopic);
$realregno = mysqli_query($dbcon,  $checkregno);
$finalResultForTopic = mysqli_fetch_assoc($realtopic);
$finalResultForRegno = mysqli_fetch_assoc($realregno);
 if ($finalResultForTopic)
   echo "<script>window.open('register.php?msg=topicExist','_self')</script>";


   elseif ($finalResultForRegno){
   echo "<script>window.open('register.php?msg=regExist','_self')</script>";
   }


 else{
    $insert = "INSERT INTO  hndtopics (studentname,studentregno,studentdate,studentsupervisor,studenttopic) 
   VALUES ('$studentname','$studentregno', '$studentdate','$studentsupervisor' ,'$studenttopic')";

  if (mysqli_query($dbcon,$insert)) {
         echo "<script>window.open('register.php?msg=success','_self')</script>";
  }
 }
}
 
else{
  echo "<script>window.open('register.php?msg=required','_self')</script>";
}
}

//admin update
if (isset($_POST['adminupdate'])) {
  $admin = trim($_POST['admin']);
  $password = trim($_POST['password']);
  $lower = trim($_POST['lower']);
  $higher = trim($_POST['higher']);
  
  $sql = "UPDATE adminsetting SET admin = '$admin', password = '$password', lower = '$lower', higher = '$higher'  WHERE id = '1'";
  if (mysqli_query($dbcon,$sql)) {
         echo "<script>window.open('dashboard.php?msg=success','_self')</script>";
    }
    else {
      # code...
    }
}


//lower level update
if (isset($_POST['updatend'])) {
  $studentname = trim($_POST['studentname']);
  $studentregno = trim($_POST['studentregno']);
  $studentdate = trim($_POST['studentdate']);
  $studenttopic = trim($_POST['studenttopic']);
  
  $sql = "UPDATE ndtopics SET studentname = '$studentname', studentregno = '$studentregno', studentdate = '$studentdate', studenttopic = '$studenttopic'  WHERE id = '$id'";
  if (mysqli_query($dbcon,$sql)) {
         echo "<script>window.open('ndrecords.php?msg=success1','_self')</script>";
    }
    else {
      # code...
    }
}



//higher level update
if (isset($_POST['updatehnd'])) {
  $studentname = trim($_POST['studentname']);
  $studentregno = trim($_POST['studentregno']);
  $studentdate = trim($_POST['studentdate']);
  $studenttopic = trim($_POST['studenttopic']);
  
  $sql = "UPDATE hndtopics SET studentname = '$studentname', studentregno = '$studentregno', studentdate = '$studentdate', studenttopic = '$studenttopic'  WHERE id = '$id'";
  if (mysqli_query($dbcon,$sql)) {
         echo "<script>window.open('hndrecords.php?msg=success1','_self')</script>";
    }
    else {
      # code...
    }
}


//check login
if (isset($_POST['adminLogin'])) {
    $uname = trim($_POST['username']);
    $pword = trim($_POST['password']);

    $sql = "SELECT * FROM adminsetting WHERE id = '1'";
  $run = mysqli_query($dbcon,$sql);
  $row = mysqli_fetch_assoc($run);

  $name = $row['admin'];
  $password = $row['password'];
      if ($uname == $name AND $pword == $password) {
        echo "<script>window.open('dashboard.php','_self')</script>";
      }

      else{
       echo "<script>window.open('login.php?msg=error','_self')</script>";
      }


}