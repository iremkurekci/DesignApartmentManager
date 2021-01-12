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
    $month = 0;
    $year = 0;
}
$email = $_SESSION['email'];
$login_session = "SELECT * FROM users WHERE email='".$email."'";
$result = mysqli_query($con,$login_session);
        $row = mysqli_fetch_array($result);
        $nameSurname = $row['nameSurname'];
        $role = $row['role'];
        $flat = $row['flat'];
        $id = $row['Id'];

$amount_db = "SELECT * FROM currentdue ORDER BY CurrentDueID DESC LIMIT 0, 1";
$result_amount = mysqli_query($con,$amount_db);
$row_amount = mysqli_fetch_array($result_amount);
$amount = $row_amount['CurrentDueAmount'];

$totalIncome = 0;
$total = "SELECT price FROM dues";
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

    $payment2 = "SELECT DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%d-%m-%Y') AS payingDate FROM dues ORDER BY date DESC";
                    $result_payment2 = mysqli_query($con,$payment2);
                    $row_payment2 = mysqli_fetch_array($result_payment2);

    $payment = "SELECT * FROM dues WHERE userID = '".$id."' ORDER BY date DESC";
    $result_payment = mysqli_query($con,$payment);

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
    <fieldset class="fieldset">
        <legend><h2>Payment History</h2></legend> 
        <?php 
        while($row_payment = mysqli_fetch_array($result_payment)){
            
            echo "<strong>".$row_payment['date']." - </strong>".$row_payment['price']."<b> $ </b><br><br>"; 
        }
        ?>
    </fieldset>
    <fieldset class="fieldset">
        <legend><h2>My Debts</h2></legend> 
        <?php 
        while($row_payment = mysqli_fetch_array($result_payment)){
            
            echo "<strong>".$row_payment['date']." - </strong>".$row_payment['price']."<b> $ </b><br><br>"; 
        }
        ?>
    </fieldset>    
    </div>
    <div class="column">
    <fieldset class="fieldset">
        <legend><h2>Pay Due</h2></legend> 
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
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
            for($i = 2020; $i <= 2030; $i++){
                echo "<option>".$i."</option>"."<br>";
            }
            ?>
        </select>
        <input type="submit" class="button" value="Find" name="find"></input>
        <br><br>
        
        <?php
        
        if(isset($_POST['find'])){
            $month = mysqli_real_escape_string($con,$_POST['months']);
            $year = mysqli_real_escape_string($con,$_POST['years']);
               $queryString = "SELECT date,CurrentDueAmount FROM currentdue WHERE YEAR(date) ='".$year."' AND MONTH(date) ='".$month."'";
               $result_amount = mysqli_query($con,$queryString);
               $row_amount = mysqli_fetch_array($result_amount); 
               $price = $row_amount['CurrentDueAmount'];             
            }?>
            <nav>
            <input type="text" <?php if(isset($_POST['find'])): ?>value="<?php echo $month?>"<?php endif; ?> class="text2" id="month" name="month" <?php if(!isset($_POST['submit']) || !isset($_POST['find'])): ?> value="" <?php endif; ?> readonly>
            <input type="text" <?php if(isset($_POST['find'])): ?>value="<?php echo $year?>"<?php endif; ?> class="text2" id="year" name="year" <?php if(!isset($_POST['submit']) || !isset($_POST['find'])): ?> value="" <?php endif; ?> readonly>
            <nav>
            <br>
            <input type="text" value="<?php echo $nameSurname?>" class="text" id="name" name="name" readonly><br><br>
            <input type="text" value="<?php echo $role?>" class="text" id="role" name="role" readonly><br><br>
            <input type="text" value="<?php echo "No: "."$flat"?>" class="text" id="flat" name="flat" readonly><br><br>
            <input type="text" <?php if(isset($_POST['find'])): ?>value="<?php echo "$price"." $"?>"<?php endif; ?> class="text" id="price" name="price" <?php if(!isset($_POST['submit']) || !isset($_POST['find'])): ?> value="" <?php endif; ?>readonly><br><br>
           
        <input type="submit" class="button" name="submit" value="Pay it"></input>
    </fieldset>   
    </div>
    <div class="column">
    </div>
</div>
</form>
<?php 
            if(isset($_POST['submit'])){
                $month = mysqli_real_escape_string($con,$_POST['month']);
                $year = mysqli_real_escape_string($con,$_POST['year']);
                

                $queryString = "SELECT * FROM dues WHERE YEAR(date) ='".$year."' AND MONTH(date) = '".$month."' AND userID='".$id."' LIMIT 1";
                echo '<script type="text/javascript">console.log("'.$queryString.'");</script>';
                $result_num = mysqli_query($con,$queryString);
                
                if(mysqli_fetch_row($result_num)){
                    echo '<script>alert("This due already paid.")</script>'; 
                }else{
                $month = mysqli_real_escape_string($con,$_POST['month']);
                $year = mysqli_real_escape_string($con,$_POST['year']);
                $queryString2 = "SELECT date,CurrentDueAmount FROM currentdue WHERE YEAR(date) ='".$year."' AND MONTH(date) ='".$month."'";
                $result_amount = mysqli_query($con,$queryString2);
                $row_amount = mysqli_fetch_array($result_amount); 
                $price = $row_amount['CurrentDueAmount']; 

                    $date = "$year"."-"."$month"."-01"; 
                    $queryString_ = "INSERT INTO dues (userID, date, price) VALUES ('".$id."','".$date."','".$price."')";
                    echo '<script type="text/javascript">console.log("'.$queryString_.'");</script>';
                   $query = $con->prepare($queryString_);
                   $query->execute();
                    }
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
