<!DOCTYPE html>
<html>
<head>
	<title>My Message Box</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="contact.css">
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
$total = "SELECT 01, 02, 03, 04, 05, 06, 07, 08, 09, 10, 11, 12 FROM dues";
$expence = "SELECT expenceAmount FROM expences";
$result_total = mysqli_query($con,$total);
$result_expence = mysqli_query($con,$expence);
$row_total = mysqli_fetch_array($result_total);
$row_expence = mysqli_fetch_array($result_expence);
while($row_total = mysqli_fetch_array($result_total)){
    $totalIncome += $row_total['01'] + $row_total['02']+ $row_total['03']+ $row_total['04']
                   + $row_total['05']+ $row_total['06']+ $row_total['07']+ $row_total['08']
                   + $row_total['09']+ $row_total['10']+ $row_total['11']+ $row_total['12']
                   - $row_expence['expenceAmount']; 


    $messages = "SELECT * FROM messages ORDER BY messageID DESC";
    $result_messages = mysqli_query($con,$messages);
    $row_messages = mysqli_fetch_array($result_messages);
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
            <form action="home.html" method="POST">
        <fieldset class="fieldset">
            <legend><h2>My Message Box</h2></legend> 
            <?php 
            while($row_messages = mysqli_fetch_array($result_messages)): ?>
            <input type="text" value="<?php echo "When: ".$row_messages['dateTime'] ?>" class="text" id="timeMail" readonly><br>
            <input type="text" value="<?php echo "From: ".$row_messages['messageFrom'] ?>" class="text" id="fromMail" readonly><br>
            <input type="text" value="<?php echo "To: $manager_mail" ?>" class="text" id="toMail" readonly><br>
            <textarea class="textarea" id="tarea" readonly><?php echo $row_messages['messageContent'] ?></textarea><br>
            <hr>
            <?php endwhile; ?>
        </fieldset>   
        </div>
        
        <div class="column"></div>
    </div>
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
