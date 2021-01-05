<?php 
include "config.php";

$flatid = 0;

if(isset($_POST['flat'])){
   $flatid = mysqli_real_escape_string($con,$_POST['flat']); // flat id
}

$users_arr = array();

if($flatid > 0){
   $sql = "SELECT * FROM users WHERE flat=".$flatid;

   $result = mysqli_query($con,$sql);

   while( $row = mysqli_fetch_array($result) ){
      $userid = $row['Id'];
      echo 
      $name = $row['nameSurname'];
      $email = $row['email'];
      $password = $row['password'];
      $role = $row['role'];

      $users_arr[] = array("Id" => $userid, "nameSurname" => $name, "email" => $email, "password" => $password, "role" => $role);
   }
}
// encoding array to json format
echo json_encode($users_arr);
?>