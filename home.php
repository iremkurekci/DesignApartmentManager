<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
    <link rel="stylesheet" href="home.css">
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    $user = "SELECT * FROM users ORDER BY flat ASC";
    $result_user = mysqli_query($con,$user);


    $amount_db = "SELECT * FROM currentdue ORDER BY CurrentDueID DESC LIMIT 0, 1";
    $result_amount = mysqli_query($con,$amount_db);
    $row_amount = mysqli_fetch_array($result_amount);
    $amount = $row_amount['CurrentDueAmount'];

    $edit = "SELECT * FROM expences";
    $result_edit = mysqli_query($con,$edit);

    $fault = "SELECT *, users.nameSurname  FROM faultrecord LEFT JOIN users ON faultrecord.userID=users.Id";
    $result_fault = mysqli_query($con,$fault);

    $announcement = "SELECT * FROM announcements";
    $result_announcement = mysqli_query($con,$announcement);
   
    $totalIncome = 0;
$total = "SELECT price FROM dues WHERE ispaid='1'";
$result_total = mysqli_query($con,$total);
while($row_total = mysqli_fetch_array($result_total)){
    $totalIncome += $row_total['price'];                   
}
$totalExpenceValue= 0;
$totalExpence = "SELECT expenceAmount FROM expences";
$result_total = mysqli_query($con,$totalExpence);
while($row_total = mysqli_fetch_array($result_total)){
    $totalExpenceValue += $row_total['expenceAmount'];                   
}
$totalIncome = $totalIncome - $totalExpenceValue;


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
    <div class="column">
    <fieldset class="fieldset">
        <legend><h2>Neighbors</h2></legend> 
    <div>
        <?php 
        while($row_user = mysqli_fetch_array($result_user)){
            echo "<strong>".$row_user['nameSurname']." / No: </strong>".$row_user['flat']."<br><br>"; }?>
    </div>
        <div>
        
    </fieldset>
    </div>
    <script>
        function myFunction(flat_id) {
            var flat = document.getElementById(flat_id);
            if (flat.style.display === "none") {
                flat.style.display = "block";
            } else{
                flat.style.display = "none";
            }
        }
    </script>
    <div class="column">
        <fieldset class="fieldset">
            <legend><h2>Current Due Amount</h2></legend>
            <?php echo $amount; ?><b>$</b>
            
        </fieldset>
        <fieldset class="fieldset">
            <legend><h2>Expences</h2></legend>
            <?php while($row_edit = $result_edit->fetch_assoc()){
                echo "<strong>".$row_edit['expenceType'].": </strong>".$row_edit['expenceAmount']."<b>$</b><br><br>"; }?>
        </fieldset>
        <fieldset class="fieldset">
            <legend><h2>Fault Records</h2></legend>
            
                <?php while($row_fault = $result_fault->fetch_assoc()){
                echo "<b> >> </b>"."<strong>".$row_fault['faultAbout'].": </strong>".$row_fault['faultRecord']." <strong> - </strong>".$row_fault['dateTime']."<i><b> (</b>".$row_fault['nameSurname']."<b>)</b></i><br><br>"; }?>
                
        </fieldset>
    </div>
    <div class="column">
    <fieldset class="fieldset">
        <legend><h2>Announcements</h2></legend>
        <?php while($row_announcement = $result_announcement->fetch_assoc()){
                echo "<b> >> </b>".$row_announcement['announcementContent']." - <strong>".$row_announcement['dateTime']."</strong><br><br>"; }?>
    </fieldset>
</div></div>
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