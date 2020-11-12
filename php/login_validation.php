<?php
include 'dbconn.php';

if (isset($_POST['submit'])){
    $username = $_POST['username'];
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];

    $errorEmpty = false;
    $errorUser = false;
    $errorEmail = false;
    $errorPassword = false;


    if(empty($username)||empty($name)||empty($dob)||empty($email)||empty($password)||empty($country)||empty($state)||empty($city)){
        echo "<span class='form-error'>Please fill in all fields</span>";
        $errorEmpty = true;
    }

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '".$username."'");
    if(mysqli_num_rows($result)>=1){
        echo "<span class='form-error'> Username already exists </span>";
        $errorUser = true;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
        echo "<span class='form-error'>Please enter a valid email.</span>"; 
        $errorEmail = true;
    }

    $result2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '".$email."'");
    if(mysqli_num_rows($result2)>=1){
        echo "<span class='form-error'> Email ID is already registered </span>";
        $errorEmail = true;
    }

    if(strlen($password) < 8){
        echo "<span class='form-error'>Password must have minimum 8 characters.</span>"; 
        $errorPassword = true; 
    }

    $error = ($errorEmpty||$errorUser||$errorEmail||$errorPassword);
    if(!$error){
        $pass = md5($password);
        $countrySQL = "SELECT `name` FROM `countries` WHERE `id`='$country'";
        $countryResult = $conn->query($countrySQL);
        if ($countryResult->num_rows> 0) {
            while($row = $countryResult->fetch_assoc()) {
                $countryName = $row['name'];
            }
        }

        $stateSQL = "SELECT `name` FROM `states` WHERE `id`='$state'";
        $stateResult = $conn->query($stateSQL);
        if ($stateResult->num_rows> 0) {
            while($row = $stateResult->fetch_assoc()) {
                $stateName = $row['name'];
            }
        }

        $citySQL = "SELECT `name` FROM `cities` WHERE `id`='$city'";
        $cityResult = $conn->query($citySQL);
        if ($cityResult->num_rows> 0) {
            while($row = $cityResult->fetch_assoc()) {
                $cityName = $row['name'];
            }
        }

        $name_mod = ucwords($name);
        $query = mysqli_query($conn, "INSERT INTO users (username, name, dob, email, password, country, state, city) VALUES ('$username','$name_mod','$dob','$email','$pass','$countryName','$stateName','$cityName')");
        if($query === false){
            throw new Exception(mysqli_error($conn));
        }
        else{
            echo '<script type="text/javascript">';
            echo ' window.location.href = "login.php";';  
            echo '</script>';
        }
    }
    
}

?>

