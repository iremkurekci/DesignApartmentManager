<!DOCTYPE html>
<html>
<head>
	<title>Report A Failure</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="report.css">
</head>
<body>
    <?php
   include('config.php');
   if(!isset($_SESSION['email'])){
    header('Location: login.php');
    }
    if(isset($_POST['logout'])){
    session_destroy();
    header('Location: login.php');
}
$email = $_SESSION['email'];
$login_session = "SELECT * FROM users WHERE email='".$email."'";
$result = mysqli_query($con,$login_session);
        $row = mysqli_fetch_array($result);
        $nameSurname = $row['nameSurname'];
        $role = $row['role'];
        $flat = $row['flat'];

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
            <legend><h2>Report A Failure</h2></legend> 
            <input type="text" value="" class="text" id="about" name="about" placeholder="About" required="required"><br>
            <textarea class="textarea" id="tarea" name="tarea" placeholder="Please write your complaint..." required></textarea>
            <input type="submit" class="button"name="submit" value="Report"></input>
        </fieldset>   
        </div>
        
        <div class="column"></div>
    </div>
    </form>
    <?php 
    if(isset($_POST['submit'])){
        $about = mysqli_real_escape_string($con,$_POST['about']);
        $record = mysqli_real_escape_string($con,$_POST['tarea']);
        $queryString = "INSERT INTO faultrecord (faultRecord,faultAbout) VALUES ('".$record."','".$about."')";
        echo "<script type='text/javascript'>console.log('$queryString');</script>";
           $query = $con->prepare($queryString);
           $query->execute();
            }
    ?>
    <br><br>
<div class="footer">
<br><span style="font-style: oblique; font-family: tahoma; color: white; float: left; padding-left:30px"><b style="color: #eb5e28;">Address: </b> <?php echo $address; ?></span><br>
    <?php 
        $manager = "SELECT * FROM users WHERE role='Manager'";
        $result_manager = mysqli_query($con,$manager);
        $row = mysqli_fetch_array($result_manager);
        $manager_name = $row['nameSurname'];
    ?>
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
