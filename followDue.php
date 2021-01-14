  <!DOCTYPE html>
<html>
<head>
	<title>Follow Dues</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="addnew.css">
    <style>
        .text2{
        margin: 15px;
        padding: 10px;
        border-color: transparent;
        border-radius: 40px;
        width: 80px;
        height: 50px;
        font-size: 15px;
        background-color: #403d39;
        opacity: 0.8;
        color: white;
        outline: none;
        float: left;
        
    }
    </style>
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

        <div class="row">
        <div class="column">
        <fieldset class="fieldset">
        <legend><h2>Query Results</h2></legend> 
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
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
        <select name="years" class="drop" id="years" required="required">
            <option selected value="select">Select a Year</option>
            
            <?php 
            for($year = 2020; $year <= 2030; $year++){
                echo "<option>".$year."</option>"."<br>";
            }
            ?>
        </select>
        <input type="submit" class="button" name="find" value="Find"></input>
        <?php
        
        if(isset($_POST['find'])){
            $month = mysqli_real_escape_string($con,$_POST['months']);
            $year = mysqli_real_escape_string($con,$_POST['years']);;             
            }?>
        <nav style="margin-right: 100px;">
        <input type="text" <?php if(isset($_POST['find'])): ?>value="<?php echo $month?>"<?php endif; ?> class="text2" id="month" name="month" <?php if(!isset($_POST['submit']) || !isset($_POST['find'])): ?> value="" <?php endif; ?> readonly>
        <input type="text" <?php if(isset($_POST['find'])): ?>value="<?php echo $year?>"<?php endif; ?> class="text2" id="year" name="year" <?php if(!isset($_POST['submit']) || !isset($_POST['find'])): ?> value="" <?php endif; ?> readonly>
        </nav><br>
        <nav style="margin-right: 0px;">
            
            <input type="submit" class="button" id="userEntry" name="userEntry" value="User Query as Entry Date" style="width:220px;">
            <input type="submit" class="button" id="userRelease" name="userRelease" value="User Query as Release Date" style="width:220px;"><br>
            <input type="submit" class="button" id="dueQuery" name="dueQuery" value="Due Query">
        </nav>
        <br><br><br>
</form>
<?php 
            if(isset($_POST['userEntry'])){
                if(mysqli_num_rows($result_payer) == 0){
                    echo "There is no result.";
                    }else{
                        $month = mysqli_real_escape_string($con,$_POST['month']);
                $year = mysqli_real_escape_string($con,$_POST['year']);
                
                $queryString = "SELECT * FROM users WHERE YEAR(entryDate) ='".$year."' AND MONTH(entryDate) = '".$month."'";
                $result_entry = mysqli_query($con,$queryString);
                echo '<script type="text/javascript">console.log("'.$queryString.'");</script>';
                while($row_entry = $result_entry->fetch_assoc()){
            
                    echo "<strong>".$row_entry['nameSurname']."</strong> - No: ".$row_entry['flat']." - ".$row_entry['email']."<br><br>"; 
                }
                    }
                
            }
                if(isset($_POST['userRelease'])){
                    if(mysqli_num_rows($result_payer) == 0){
                        echo "There is no result.";
                        }else{
                    $month = mysqli_real_escape_string($con,$_POST['month']);
                    $year = mysqli_real_escape_string($con,$_POST['year']);
                    
                    $queryString = "SELECT * FROM users WHERE YEAR(releaseDate) ='".$year."' AND MONTH(releaseDate) = '".$month."'";
                    $result_release = mysqli_query($con,$queryString);
                    echo '<script type="text/javascript">console.log("'.$queryString.'");</script>';
                    while($row_release = $result_release->fetch_assoc()){
                
                        echo "<strong>".$row_release['nameSurname']."</strong>"." - ".$row_release['email']."<br><br>"; 
                    }
                }
                }
                if(isset($_POST['dueQuery'])){
                    if(mysqli_num_rows($result_payer) == 0){
                        echo "There is no result.";
                        }else{
                    $month = mysqli_real_escape_string($con,$_POST['month']);
                    $year = mysqli_real_escape_string($con,$_POST['year']);
                    
                    $queryString = "SELECT *,.users.nameSurname FROM dues LEFT JOIN users ON dues.userID=users.Id WHERE YEAR(date) ='".$year."' AND MONTH(date) = '".$month."'";
                    $result_due = mysqli_query($con,$queryString);
                     
                    while($row_due = $result_due->fetch_assoc()){
                
                        echo "<strong>".$row_due['date']."</strong><b> - </b>".$row_due['price']."<b> / </b>".$row_due['nameSurname']."<br><br>"; 
                    }
                }
                }
                if(!isset($_POST['dueQuery']) || !isset($_POST['userRelease']) || !isset($_POST['userEntry'])){
                    echo "Select a date and click related button.";
                }
            ?>
        </fieldset>  
    </div>
        <div class="column">
    <fieldset class="fieldset">
        <legend><h2>Query Results</h2></legend> 
        <?php 
            if(isset($_POST['userEntry'])){
                if(mysqli_num_rows($result_payer) == 0){
                    echo "There is no result.";
                    }else{
                        $month = mysqli_real_escape_string($con,$_POST['month']);
                $year = mysqli_real_escape_string($con,$_POST['year']);
                
                $queryString = "SELECT * FROM users WHERE YEAR(entryDate) ='".$year."' AND MONTH(entryDate) = '".$month."'";
                $result_entry = mysqli_query($con,$queryString);
                echo '<script type="text/javascript">console.log("'.$queryString.'");</script>';
                while($row_entry = $result_entry->fetch_assoc()){
            
                    echo "<strong>".$row_entry['nameSurname']."</strong> - No: ".$row_entry['flat']." - ".$row_entry['email']."<br><br>"; 
                }
                    }
                
            }
                if(isset($_POST['userRelease'])){
                    if(mysqli_num_rows($result_payer) == 0){
                        echo "There is no result.";
                        }else{
                    $month = mysqli_real_escape_string($con,$_POST['month']);
                    $year = mysqli_real_escape_string($con,$_POST['year']);
                    
                    $queryString = "SELECT * FROM users WHERE YEAR(releaseDate) ='".$year."' AND MONTH(releaseDate) = '".$month."'";
                    $result_release = mysqli_query($con,$queryString);
                    echo '<script type="text/javascript">console.log("'.$queryString.'");</script>';
                    while($row_release = $result_release->fetch_assoc()){
                
                        echo "<strong>".$row_release['nameSurname']."</strong>"." - ".$row_release['email']."<br><br>"; 
                    }
                }
                }
                if(isset($_POST['dueQuery'])){
                    if(mysqli_num_rows($result_payer) == 0){
                        echo "There is no result.";
                        }else{
                    $month = mysqli_real_escape_string($con,$_POST['month']);
                    $year = mysqli_real_escape_string($con,$_POST['year']);
                    
                    $queryString = "SELECT *,.users.nameSurname FROM dues LEFT JOIN users ON dues.userID=users.Id WHERE YEAR(date) ='".$year."' AND MONTH(date) = '".$month."'";
                    $result_due = mysqli_query($con,$queryString);
                     
                    while($row_due = $result_due->fetch_assoc()){
                
                        echo "<strong>".$row_due['date']."</strong><b> - </b>".$row_due['price']."<b> / </b>".$row_due['nameSurname']."<br><br>"; 
                    }
                }
                }
                if(!isset($_POST['dueQuery']) || !isset($_POST['userRelease']) || !isset($_POST['userEntry'])){
                    echo "Select a date and click related button.";
                }
            ?>
    </fieldset>   
    </div>
    
    <div class="column">
    <fieldset class="fieldset">
        <legend><h2>All Depts</h2></legend> 
    <div>
        <?php
        $dept = "SELECT * FROM dues WHERE YEAR(date) = 0000 AND MONTH(date) = 00 ORDER BY date DESC";
        $result_dept = mysqli_query($con,$dept);
        
        if(mysqli_num_rows($result_dept) == 0){
            echo "There is no paid due to show.";
        }
        ?>
</div>
        <div>
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