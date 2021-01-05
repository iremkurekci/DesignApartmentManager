<!DOCTYPE html>
<html>
<head>
	<title>Sign In</title>
	<link rel="stylesheet" href="login.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="imgcontainer">
    <img src="https://www.w3schools.com/howto/img_avatar2.png" alt="Avatar" class="avatar">
  </div>

  <div class="container">
  <label for="email"><h3>Name Surname</h3></label>
    <input type="text" placeholder="Enter Name-Surname" name="nameSurname" required>

    <label for="email"><h3>E-mail</h3></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label for="password"><h3>Password</h3></label>
    <input type="password" placeholder="Enter Password" name="password" required>

    <label for="password"><h3>Password Again</h3></label>
    <input type="password" placeholder="Enter Password Again" name="passwordAgain" required>

    <select name="flat" class="drop" id="flat" required="required">
            <option selected value="select">Select A Flat</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
        </select><br><br>
        <select name="role" class="drop" id="role" required="required">
            <option selected value="select">Select A Role</option>
            <option value="Manager">Manager</option>
            <option value="User">User</option>
        </select><br><br>

    <button class="signin" name="submit" type="submit" onclick="click()">Sign in</button><br>
  </div>
<script type="text/javascript">
	function redirect(){
		window.location("login.php");
	}
</script>
  <div class="container" style="background-color:#f1f1f1">
    <span class="password"><a href="#">Forgot password?</a></span>
  </div>
    </form>
    <script>
    function myFunction(){
        var flat = document.getElementById("flat");
        var selectedFlat= flat.options[flat.selectedIndex].value;
        var role = document.getElementById("role");
        var selectedRole = role.options[role.selectedIndex].value;

        if (selectedFlat == "select" || selectedRole == "select"){
            alert("Please select an option");
        }
        else{
            //alert("New neighbor is added successfully!")
        }
    }
</script>
    <?php
   include("config.php");
   //session_start();
   
   if(isset($_POST['submit'])){

    $nameSurname = mysqli_real_escape_string($con,$_POST['nameSurname']);
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $password1 = mysqli_real_escape_string($con,$_POST['password']);
    $password2 = mysqli_real_escape_string($con,$_POST['passwordAgain']);
    if($password1 === $password2){
        $password = $password1;
    }
    else{
        echo '<script language="javascript">';
echo 'alert("Please sure about your password is correct")';
echo '</script>';
exit;
    }
    $password_md5 = md5($password);
    $flat = mysqli_real_escape_string($con,$_POST['flat']);
    $role = mysqli_real_escape_string($con,$_POST['role']);
       $queryString = "INSERT INTO users (nameSurname,email,password,flat,role) VALUES ('".$nameSurname."','".$email."','".$password_md5."','".$flat."','".$role."')";
    echo "<script type='text/javascript'>console.log('$queryString');</script>";
       $query = $con->prepare($queryString);
       //$query->bind_param('s',$nameSurname, 's',$email, 's',$password, 'i',$flat, 's',$role);
       //$query ->bind_param('sssis',$nameSurname,$email,$password,$flat,$role);
       $query->execute();
}
?>
<script type="text/javascript">
    function click(){
        window.location("login.php");
    }
</script>
</body>
</html>
