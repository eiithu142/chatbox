<?php 
 
  $conn=mysqli_connect("localhost","root","","singup");
  if($conn){
   //echo"conneted";
  }
  else{
   echo "failed";
  }
  $username=['username'];
  $email=['mail'];
  $password = ['password'];
  
$data = "INSERT INTO `train` (`username`,`email`,`password`) VALUES ('', '','')";
 
?>