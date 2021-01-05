  <!DOCTYPE html>
<html>
<head>
	<title>Update Neighbors</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="addnew.css">
</head>
<body>
    <?php
   include('config.php');

    if(isset($_POST['logout'])){
    session_destroy();
    header('Location: login.php');
}
$email = $_SESSION['email'];
$login_session = "SELECT * FROM users WHERE email='".$email."'";
$result = mysqli_query($con,$login_session);
        $row = mysqli_fetch_array($result);
        $nameSurname = $row['nameSurname'];
        $password = $row['password'];
        $flat = $row['flat'];
        $role = $row['role'];
        $id = $row['Id'];

        $manager = "SELECT * FROM users WHERE role='Manager'";
        $result_manager = mysqli_query($con,$manager);
        $row_manager = mysqli_fetch_array($result_manager);
        $manager_name = $row_manager['nameSurname'];
        $manager_mail = $row_manager['email'];

        $totalIncome = 0;
$total = "SELECT price FROM dues";
$result_total = mysqli_query($con,$total);
$row_total = mysqli_fetch_array($result_total);
while($row_total = mysqli_fetch_array($result_total)){
    $totalIncome += $row_total['price']; 
}
$address_db = "SELECT * FROM address ORDER BY addressID DESC LIMIT 0, 1";
    $result_address = mysqli_query($con,$address_db);
    $row_address = mysqli_fetch_array($result_address);
    $address = $row_address['address'];
?>
<header>

    <div class="container">
       <form method="POST" action="">
            <button name="logout" class="close">&times;</button>
        </form>
       <a href="home.php" class="logo" style="font: bold;">mynger</a>
        <nav>
            <ul>
                <?php if ($role == "Manager"): ?>
                <li class="settings" style="display: block;"><a href="settings.php">Settings</a></li>
                <?php endif; ?>
                <li class="topnav"><a href="home.php">Home</a></li>
                <li class="topnav"><a href="paydue.php">Pay Due</a></li>
                <li class="topnav"><a href="report.php">Report a Failure</a></li>
                <?php if ($role != "Manager"): ?>
                <li class="topnav" style="display: block;"><a href="contact.php">Contact us</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
<div>
<span style="font-style: oblique; font-family: tahoma; color: #252422; float: left; padding-left:30px"><br><b style="color: #eb5e28;">Welcome</b><br> <?php echo $nameSurname; ?> / <?php echo $role; ?></span>
<span style="font-style: oblique; font-family: tahoma; color: #252422; float:right; padding-right:30px"><br><b style="color: #eb5e28;">Total Income </b><br><?php echo $totalIncome."$" ?></span><br><br><br><hr>
</div>
<div class="row">
    <div class="column"></div>
    <div class="column">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <fieldset class="fieldset">
        <legend><h2>Update Neighbors</h2></legend> 
        <select name="flat" class="drop" id="flat" required="required">
            <option selected value="select">Select a flat</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
        </select><br><br>
      
        <?php 
        $selected_person = "SELECT * FROM users WHERE flat='flat'";
        $result_person = mysqli_query($con,$selected_person);
                while($row_person = $result_person->fetch_assoc()){
                $email_person = $row_person['email'];
                $password_person = $row_person['password'];
                $nameSurname_person = $row_person['nameSurname'];
                $role_person = $row_person['role'];
                }
                
        ?>
        <input type="text" value="" class="text" id="name" name="nameSurname" placeholder="Name Surname" required><br><br>
        <input type="email" value="" class="text" id="email" name="email" placeholder="E-mail" required><br><br>
        <input type="text" value="" class="text" id="password" placeholder="Password" name="password" required><br><br>
        
        <select name="role" class="drop" id="role" required="required">
            <option selected value="">Select A Role</option>
            <option value="Manager">Manager</option>
            <option value="User">User</option>
        </select><br><br>
        <input type="submit" class="button" value="Update" name="submit"></input>
    </fieldset>   
    </div>
    
    <div class="column"></div>
</div>
<script type="text/javascript">
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

if(isset($_POST['submit'])){
    
    echo "<script type='text/javascript'>console.log('asdasdasd');</script>";
    $nameSurname = mysqli_real_escape_string($con,$_POST['nameSurname']);
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $password = mysqli_real_escape_string($con,$_POST['password']);
    $password_md5 = md5($password);
    $flat = mysqli_real_escape_string($con,$_POST['flat']);
    $role = mysqli_real_escape_string($con,$_POST['role']);
       $queryString = "UPDATE users SET nameSurname = '$nameSurname', email = '$email', password = '$password_md5', flat = '$flat', role = '$role' WHERE flat = $flat";
    echo "<script type='text/javascript'>console.log('$queryString');</script>";
       $query = $con->prepare($queryString);
       //$query->bind_param('s',$nameSurname, 's',$email, 's',$password, 'i',$flat, 's',$role);
       //$query ->bind_param('sssis',$nameSurname,$email,$password,$flat,$role);
       $query->execute();
       
    }?>
</form>
<br><br>
<div class="footer">
<br><span style="font-style: oblique; font-family: tahoma; color: white; float: left; padding-left:30px"><b style="color: #eb5e28;">Address: </b> <?php echo $address; ?></span><br>
        <p style="float: left;">Manager: <?php echo $manager_name ?></p>
        
        
    <p style="float: right;"><span id="date_time"></span></p>
    <b>İsmihan İrem Kürekçi</b>
</div>
    <script>
        var dt = new Date();
        document.getElementById("date_time").innerHTML = dt.toLocaleString();
    </script>
</div>
</body>
</html>
