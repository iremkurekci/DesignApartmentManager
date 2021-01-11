<!DOCTYPE html>
<html>
<head>
	<title>Pay Due</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="paydue.css">
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

$amount_db = "SELECT * FROM currentdue ORDER BY CurrentDueID DESC LIMIT 0, 1";
$result_amount = mysqli_query($con,$amount_db);
$row_amount = mysqli_fetch_array($result_amount);
$amount = $row_amount['CurrentDueAmount'];

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


    $payment = "SELECT * FROM dues WHERE userName = '".$nameSurname."' ORDER BY year DESC";
    $result_payment = mysqli_query($con,$payment);
    $row_payment = mysqli_fetch_array($result_payment);
}
$address_db = "SELECT * FROM address ORDER BY addressID DESC LIMIT 0, 1";
    $result_address = mysqli_query($con,$address_db);
    $row_address = mysqli_fetch_array($result_address);
    $address = $row_address['address'];
?>
<header>

    <div class="container">
       <form method="POST" action="home.php">
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
<span style="font-style: oblique; font-family: tahoma; color: #252422; float:right; padding-right:30px"><br><b style="color: #eb5e28;">Total Income </b><br> <?php echo $totalIncome."$" ?></span><br><br><br><hr>
</div>

<div class="row">
    <div class="column">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <fieldset class="fieldset">
        <legend><h2>Payment History</h2></legend> 
        <?php 
        while($row_payment = mysqli_fetch_array($result_payment)){
            
            echo "<strong>".$row_payment['month']."/".$row_payment['year']." - </strong>".$row_payment['userName']."<b> / </b>".$row_payment['role']."<b> / </b> <strong>No: </strong> ".$row_payment['flat']."<br><br>"; 
        }
        ?>
    </fieldset>   
    </div>
    <div class="column">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <fieldset class="fieldset">
        <legend><h2>Pay Due</h2></legend> 
        <select name="months" class="drop" id="months" required="required">
            <option selected value="select">Select a Month</option>
            <option value="01">January</option>
            <option value="02">February</option>
            <option value="03">March</option>
            <option value="04">April</option>
            <option value="05">May</option>
            <option value="06">June</option>
            <option value="07">July</option>
            <option value="08">August</option>
            <option value="09">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>
        <select name="years" class="drop" id="years" name="years" required="required">
            <option selected value="select">Select a Year</option>
            
            <?php 
            for($year = 2020; $year <= 2030; $year++){
                echo "<option>".$year."</option>"."<br>";
            }
            ?>
        </select>
        <br><br>
        <input type="text" value="<?php echo $nameSurname?>" class="text" id="name" name="name" readonly><br><br>
        <input type="text" value="<?php echo $role?>" class="text" id="role" name="role" readonly><br><br>
           <b>Flat:</b><input type="text" value="<?php echo "$flat"?>" class="text" id="flat" name="flat" readonly><br><br>
           <b>Price:</b><input type="text" value="<?php echo "$amount"?>" class="text" id="price" name="price" readonly><br><br>
        <input type="submit" class="button" name="submit" value="Pay it"></input>
    </fieldset>   
    </div>
    
    <div class="column"></div>
</div>
</form>
<?php 
            if(isset($_POST['submit'])){
                $year = mysqli_real_escape_string($con,$_POST['years']);
                $month = mysqli_real_escape_string($con,$_POST['months']);
                $queryString = "INSERT INTO dues (year,month) VALUES ('".$year."','".$month."','".$username."','".$flat."','".$role."','".$price."')";
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
