<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="login.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<form action="" method="POST">
        <div class="imgcontainer">
    <img src="https://www.w3schools.com/howto/img_avatar2.png" alt="Avatar" class="avatar">
  </div>

  <div class="container">
    <label for="email"><h3>email</h3></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label for="password"><h3>Password</h3></label>
    <input type="password" placeholder="Enter Password" name="password" required>

    <button class="login" name="submit" type="submit">Login</button><br>
    <button onclick="redirect()" class="signin">Sign in</button>
  </div>
<script type="text/javascript">
	function redirect(){
		window.location("signin.php");
	}
</script>
  <div class="container" style="background-color:#f1f1f1">
    <span class="password"><a href="#">Forgot password?</a></span>
  </div>
    </form>
    <?php
   include("config.php");
   //session_start();
   
   if(isset($_POST['submit'])){

    $email = mysqli_real_escape_string($con,$_POST['email']);
    $password = mysqli_real_escape_string($con,$_POST['password']);
    $password = md5($password);

    if ($email != "" && $password != ""){

        $sql_query = "SELECT count(*) as count FROM users WHERE email='".$email."' AND password='".$password."'";
        $result = mysqli_query($con,$sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['count'];

        if($count > 0){
            $_SESSION['email'] = $email;
            header('Location: home.php');
        }else{
            echo "Invalid username or password";
        }

    }

}
?>
</body>
</html>
