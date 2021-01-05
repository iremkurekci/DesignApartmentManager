  <!DOCTYPE html>
<html>
<head>
	<title>Settings</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="settings.css">
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
        $role = $row['role'];

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
<div style="margin-top: 30px; margin:auto; width: 60%;">
<span style="float: left;"><a href="addnew.php" style="color: #252422; font-family: tahoma; margin-right:60px;"><img alt="Add_image" src="https://i.hizliresim.com/QzmAPg.png" 
width="100" height="100" style="border-radius: 20px; border-color:transparent; margin:20px; outline:none;"><br>Add New Neighbor</a></span>
<span style="float: left;"><a href="update.php" style="color: #252422; font-family: tahoma; margin-right:60px;"><img alt="Update_image" src="https://i.hizliresim.com/9HhtVn.png" 
width="100" height="100" style="border-radius: 20px; border-color:transparent; margin:20px; outline:none;"><br>Update Neighbors</a></span>
<span style="float: left;"><a href="delete.php" style="color: #252422; font-family: tahoma; margin-right:60px;"><img alt="Delete_image" src="https://i.hizliresim.com/nsfkeD.png" 
width="100" height="100" style="border-radius: 20px; border-color:transparent; margin:20px; outline:none;"><br>Delete A Neighbor</a></span>
</div>
<br>
<div style="margin-top: 30px; margin:auto; width: 60%;">
<span style="float: left;"><a href="assignDue.php" style="color: #252422; font-family: tahoma; margin-right:50px;"><img alt="CurrentDue_image" src="https://i.hizliresim.com/rKGBQd.png" 
width="100" height="100" style="border-radius: 20px; border-color:transparent; margin:20px; outline:none;"><br>Assign Due Amount</a></span>
<span style="float: left;"><a href="editExpences.php" style="color: #252422; font-family: tahoma; margin-right:105px;"><img alt="CurrentBills_image" src="https://i.hizliresim.com/lvIYzd.jpg" 
width="100" height="100" style="border-radius: 20px; border-color:transparent; margin:20px; outline:none;"><br>Edit Expences</a></span>
<span style="float: left;"><a href="editAnnouncements.php" style="color: #252422; font-family: tahoma; margin-right:60px;"><img alt="Announcements_image" src="https://i.hizliresim.com/6uECvC.png" 
width="100" height="100" style="border-radius: 20px; border-color:transparent; margin:20px; outline:none;"><br>Edit Announcements</a></span>
</div>
<br>
<div style="margin-top: 30px; margin:auto; width: 60%;">
<span style="float: left;"><a href="followDue.php" style="color: #252422; font-family: tahoma; margin-right:115px;"><img alt="FollowDues_image" src="https://i.hizliresim.com/GlU5O7.png" 
width="100" height="100" style="border-radius: 20px; border-color:transparent; margin:20px; outline:none;"><br>Follow Dues</a></span>
<span style="float: left;"><a href="changeAddress.php" style="color: #252422; font-family: tahoma; margin-right:80px;"><img alt="ChangeAddress_image" src="https://i.hizliresim.com/ecx2WQ.png" 
width="100" height="100" style="border-radius: 20px; border-color:transparent; margin:20px; outline:none;"><br>Change Address</a></span>
<span style="float: left;"><a href="messagebox.php" style="color: #252422; font-family: tahoma; margin-right:70px;"><img alt="FollowMembers_image" src="https://i.hizliresim.com/kZIjfr.jpg" 
width="100" height="100" style="border-radius: 20px; border-color:transparent; margin:20px; outline:none;"><br>My Message Box</a></span>
</div>
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