<?php
include 'dbconn.php';

if (isset($_POST['Login'])){
    $success = true;
    $name = $_POST["login_user"];
    $password = $_POST["login_pass"];

    if(empty($name)){
        echo '<script type="text/javascript">';
        echo ' alert("Username required")';  
        echo '</script>';
        $success = false;
    }

    if(strlen($password) < 8){
        echo '<script type="text/javascript">';
        echo ' alert("Password must have minimum 8 characters.")';  
        echo '</script>';
        $success = false;
    }

    if($success){
        $pass = md5($password);
        $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '" . $name. "' and password = '" . $pass. "'");
        if($result === false){
            throw new Exception(mysqli_error($conn));
        }

        if ($row = mysqli_fetch_array($result)){
            session_start();
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['country'] = $row['country'];
            $_SESSION['state'] = $row['state'];
            $_SESSION['city'] = $row['city'];
            header("location: landing.php");
            } 
        else{
            echo '<script type="text/javascript">';
            echo ' alert("Invalid Email or Password")';  
            echo '</script>';
            }

        }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Sign Up or Sign In</title>
        <!--Font awesome CDN-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="../js/pagetransition.js"></script>
        <link rel="stylesheet" href="../css/pagetransition.css">
        <link rel="stylesheet" href="../css/login.css">

        <!-- registration form script -->
        <script>
            $(document).ready(function(){
                $("#register").submit(function(event){
                    event.preventDefault();
                    var username = $("#reg_user").val();
                    var name = $("#reg_name").val();
                    var dob = $("#reg_dob").val();
                    var email = $("#reg_email").val();
                    var password = $("#reg_pass").val();
                    var country = $("#country").val();
                    var state = $("#state").val();
                    var city = $("#city").val();
                    var submit = $("#reg_submit").val();
                    $(".form-message").load("login_validation.php",{
                        username: username,
                        name: name,
                        dob: dob,
                        email: email,
                        password: password,
                        country: country,
                        state: state,
                        city: city,
                        submit: submit
                    });
                });
            });
        </script>
    </head>
    <body>
    <div class="pgtransition transition-2 is-active">
        <div class="loading">
            <div class="dot dot-1"></div>
            <div class="dot dot-2"></div>
            <div class="dot dot-3"></div>
        </div>
    </div>  <!--page transition-->
        <div class="container">
            <div class="forms-container">
                <div class="signin-signup">
                    <!-- Sign in form -->
                    <form action="login.php" method="POST" class="sign-in-form" id="SignIn">
                        <h2 class="title">Sign In</h2>
                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="text" name="login_user" placeholder="Username" required>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="login_pass" placeholder="Password" required>
                        </div>
                        <input type="submit" value="Login" name="Login" class="btn solid">
                    </form>
                    <!-- Sign in form ends -->
                    <!-- Registration form -->
                    <form id="register" action="login_validation.php" method="POST" class="sign-up-form">
                        <h2 class="title">Register</h2>
                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="text" name="reg_user" id="reg_user" placeholder="Username" required>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-id-card"></i>
                            <input type="text" name="reg_name" id="reg_name" placeholder="Name Surname" required>
                        </div>
                        <div class="input-field">
                            <i>DOB</i>
                            <input type="date" name="reg_dob" id="reg_dob" value="2000-01-01" required>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="reg_email" id="reg_email" placeholder="Email ID" required>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="reg_pass" id="reg_pass" placeholder="Password (Minimum Length: 8)" required>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-globe"></i>
                            <select id="country" name="reg_country" class="form-control" required>
                                <option value="">--- Select Country ---</option>
                                <?php
                                $countryData="SELECT `id`,`name` FROM `countries`";
                                $result=mysqli_query($conn,$countryData);
                                if(mysqli_num_rows($result)>0)
                                {
                                  while($arr=mysqli_fetch_assoc($result))
                                  {
                                 ?>
                                 <option value="<?php echo $arr['id']; ?>"><?php echo $arr['name']; ?></option>
                               <?php }} ?>
                            </select> 
                        </div>
                        <div class="input-field">
                            <i class="fas fa-map"></i>
                            <select id="state" name="reg_state" class="form-control" required>
                                <option value="">--- Select State ---</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-map-marker"></i>
                            <select id="city" name="reg_city" class="form-control" required>
                                <option value="">--- Select City ---</option>
                            </select>
                        </div>
                        <p class="form-message"></p>
                        <input type="submit" value="Sign Up" name="SignUp" id="reg_submit" class="btn solid">
                    </form>
                    
                    <!-- Registration form ends -->
                </div>
            </div>

            <div class="panels-container">
                <div class="panel left-panel">
                    <div class="content">
                        <h3>New here?</h3>
                        <p>Fill in your details and become a member now!</p>
                        <button class="btn transparent" id="sign-up-btn">Sign Up</button>
                    </div>
                    <img src="../images/reading.svg" class="image" alt="">
                </div>
                <div class="panel right-panel">
                    <div class="content">
                        <h3>One of us?</h3>
                        <p>Login and start broswing!</p>
                        <button class="btn" id="sign-in-btn">Sign in</button>
                    </div>
                    <img src="../images/booklover.svg" class="image" alt="">
                </div>
            </div>
        </div>
    <script src="../js/login.js"></script>
    <script src="../js/ajax-script.js" type="text/javascript"></script>
    </body>
</html>