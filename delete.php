<!DOCTYPE html>
<html>
<head>
	<title>Delete A Neighbor</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="addnew.css">
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
        
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
    <div class="column"></div>
    <div class="column">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <fieldset class="fieldset">
        <legend><h2>Delete A Neighbor</h2></legend> 
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <select name="flat" class="drop" id="flat" required="required">
        <option selected value="select">Select a flat</option>
        <?php 
            for($flat = 1; $flat <= 20; $flat++){
                echo "<option value='$flat'>".$flat."</option>"."<br>";
            }
            ?>
        </select>
        <input type="submit" class="button" value="Find" name="find"></input>
        <br><br>
        </from>
        <script>
        <?php
        if(isset($_POST['find'])){
                $flat = mysqli_real_escape_string($con,$_POST['flat']);
            
                   $queryString = "SELECT * FROM users WHERE flat = $flat";
                   $result_flat = mysqli_query($con,$queryString);
                   $row_flat = mysqli_fetch_array($result_flat);
                   $name_flat = $row_flat['nameSurname'];
                   $email_flat = $row_flat['email'];
                   $password_flat = $row_flat['password'];
                   $role_flat = $row_flat['role'];
        }?>
        
    
    function myFunction(){
        
        var flat = document.getElementById("flat");
        var selectedFlat= flat.options[flat.selectedIndex].value;
        var name = document.getElementById;('name');
       
        if (selectedFlat == "select"){
            alert("Please select an option");
        }
        else{
            selectedFlat.onchange = function(){
                name.value = $nameSurname_person;
            }
        }
    }
</script>
<input type="text" class="text" id="name" name="nameSurname" <?php if(isset($_POST['find'])): ?>value="<?php echo $name_flat ?>" <?php endif; ?> 
                        <?php if(!isset($_POST['find'])): ?> value="Name Surname" <?php endif; ?> readonly><br><br>
        <input type="email" class="text" id="email" name="email"<?php if(isset($_POST['find'])): ?> value="<?php echo $email_flat ?>" <?php endif; ?> 
                        <?php if(!isset($_POST['find'])): ?> value="E-mail" <?php endif; ?>readonly><br><br>
        <input type="text" class="text" id="password" name="password"<?php if(isset($_POST['find'])): ?> value="<?php echo $password_flat ?>"<?php endif; ?> 
                        <?php if(!isset($_POST['find'])): ?> value="Password" <?php endif; ?>readonly><br><br>
        <input type="text" class="text" id="role" name="role"<?php if(isset($_POST['find'])): ?> value="<?php echo $role_flat ?>" <?php endif; ?> 
                        <?php if(!isset($_POST['find'])): ?> value="Role" <?php endif; ?>readonly><br><br>

        <input type="submit" class="button" value="Delete" name="submit"></input>
    </fieldset>   
    </div>
    
    <div class="column"></div>
</div>

<?php 
include("config.php");

if(isset($_POST['submit'])){
    
    $nameSurname = mysqli_real_escape_string($con,$_POST['nameSurname']);
    $queryS = "SELECT *,.users.nameSurname FROM dues LEFT JOIN users ON dues.userID=users.Id WHERE ispaid='1' AND users.nameSurname='".$nameSurname."'";
    echo '<script type="text/javascript">console.log("'.$queryS.'");</script>';
    $resultQuery =  mysqli_query($con,$queryS);
    if(mysqli_num_rows($resultQuery) == 0){
        $queryString = "DELETE FROM users WHERE nameSurname = '".$nameSurname."'";
    echo '<script type="text/javascript">console.log("'.$queryString.'");</script>';
    }else{
        echo '<script>alert("This user has some unpaid dues. Please pay them before deleting.")</script>'; 
    }
       $query = $con->prepare($queryString);
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