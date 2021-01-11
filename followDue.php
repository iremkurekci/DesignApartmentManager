  <!DOCTYPE html>
<html>
<head>
	<title>Follow Dues</title>
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
        $role = $row['role'];

        $manager = "SELECT * FROM users WHERE role='Manager'";
        $result_manager = mysqli_query($con,$manager);
        $row_manager = mysqli_fetch_array($result_manager);
        $manager_name = $row_manager['nameSurname'];
        $manager_mail = $row_manager['email'];

    $payer = "SELECT * FROM dues ORDER BY year AND month DESC";
    $result_payer = mysqli_query($con,$payer);
    $row_payer = mysqli_fetch_array($result_payer);

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
}
$address_db = "SELECT * FROM address ORDER BY addressID DESC LIMIT 0, 1";
    $result_address = mysqli_query($con,$address_db);
    $row_address = mysqli_fetch_array($result_address);
    $address = $row_address['address'];
?>
<header>

    <div class="container">
       <form method="post" action="">
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
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<select name="months" class="drop" id="months" required="required">
            <option selected value="select">Select a Month</option>
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select><br>
        <select name="years" class="drop" id="years" name="years" required="required">
            <option selected value="select">Select a Year</option>
            
            <?php 
            for($year = 2000; $year <= 2030; $year++){
                echo "<option>".$year."</option>"."<br>";
            }
            ?>
        </select><br>
<div class="row">
    <input type="submit" class="button" name="submit" value="Search" style="float: left; margin-left:30px;"></input>
        </form>
    <div class="column">
    <fieldset class="fieldset">
        <legend><h2>Payers</h2></legend> 
    <div>
        <?php 
        if(isset($_POST['submit'])){
            $month = mysqli_real_escape_string($con,$_POST['months']);
            $year = mysqli_real_escape_string($con,$_POST['years']);
            $payers = "SELECT * FROM dues WHERE month='".$month."' AND year='".$year."' ORDER BY flat ASC";
            $result_payers = mysqli_query($con,$payers);
            $row_payers = mysqli_fetch_array($result_payers);
                }
        $message = "There are no results matching your search.";
        
        while($row_payers = mysqli_fetch_array($result_payers)){
            
            $message = "<strong>".$row_payers['month']."/".$row_payers['year']." - </strong>".$row_payers['userName']."<b> / </b>".$row_payers['role']."<b> / </b> <strong>No: </strong> ".$row_payers['flat']."<br><br>"; 
            }
            echo $message; 
        
        ?>
</div>
        <div>
        
    </fieldset>
    </div>
    <div class="column">
    <fieldset class="fieldset">
        <legend><h2>All Payments</h2></legend> 
        
        <?php 
        while($row_payer = mysqli_fetch_array($result_payer)){
            
            echo "<strong>".$row_payer['month']."/".$row_payer['year']." - </strong>".$row_payer['userName']."<b> / </b>".$row_payer['role']."<b> / </b> <strong>No: </strong> ".$row_payer['flat']."<br><br>"; 
        }
        ?>

    </fieldset>   
    </div>
   
</div>

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