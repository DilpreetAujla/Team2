<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (isset($_POST['change'])) {
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' and contactno='$contact'");
    $num = mysqli_fetch_array($query);
    if ($num > 0) {
        $extra = "forgot-password.php";
        mysqli_query($con, "update users set password='$password' WHERE email='$email' and contactno='$contact' ");
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("location:http://$host$uri/$extra");
        $_SESSION['errmsg'] = "Password Changed Successfully";
        exit();
    } else {
        $extra = "forgot-password.php";
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("location:http://$host$uri/$extra");
        $_SESSION['errmsg'] = "Invalid email id or Contact no";
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Meta -->
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

        <title>SForgot Password</title>

        <!-- Bootstrap Core CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">

        <!-- Customizable CSS -->
        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/css/green.css">
        <link rel="stylesheet" href="assets/css/owl.carousel.css">
        <link rel="stylesheet" href="assets/css/owl.transitions.css">
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>

        <!-- Favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <script type="text/javascript">
            function valid()
            {
                if (document.register.password.value != document.register.confirmpassword.value)
                {
                    alert("Password and Confirm Password Field do not match  !!");
                    document.register.confirmpassword.focus();
                    return false;
                }
                return true;
            }
        </script>
    </head>
    <body class="cnt-home">



       
        <header class="header-style-1">

            
<?php include('includes/top-header.php'); ?>

<?php include('includes/main-header.php'); ?>
        
<?php include('includes/menu-bar.php'); ?>
            

        </header>

        
        <div class="breadcrumb">
            <div class="container">
                <div class="breadcrumb-inner">
                    <ul class="list-inline list-unstyled">
                        <li><a href="home.html">Home</a></li>
                        <li class='active'>Forgot Password</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="body-content outer-top-bd">
            <div class="container">
                <div class="sign-in-page inner-bottom-sm">
                    <div class="row">
                        <!-- Sign-in -->			
                        <div class="col-md-6 col-sm-6 sign-in">
                            <h4 class="">Forgot password</h4>
                            <form class="register-form outer-top-xs" name="register" method="post">
                                <span style="color:red;" >
<?php
echo htmlentities($_SESSION['errmsg']);
?>
<?php
echo htmlentities($_SESSION['errmsg'] = "");
?>
                                </span>
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1">Email Address <span>*</span></label>
                                    <input type="email" name="email" class="form-control unicase-form-control text-input" id="exampleInputEmail1" required >
                                </div>
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputPassword1">Contact no <span>*</span></label>
                                    <input type="text" name="contact" class="form-control unicase-form-control text-input" id="contact" minlength="10" maxlength="10" required>
                                </div>
                                <div class="form-group">
                                    <label class="info-title" for="password">Password. <span>*</span></label>
                                    <input type="password" class="form-control unicase-form-control text-input" id="password" name="password" minlength="6" required >
                                </div>

                                <div class="form-group">
                                    <label class="info-title" for="confirmpassword">Confirm Password. <span>*</span></label>
                                    <input type="password" class="form-control unicase-form-control text-input" id="confirmpassword" name="confirmpassword" minlength="6" required >
                                </div>



                                <button type="submit" class="btn-upper btn btn-primary checkout-page-button" name="change">Change</button>
                            </form>					
                        </div>
                        


                        			</div>
                </div>
            </div>
        </div>
<?php include('includes/footer.php'); ?>
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/scripts.js"></script>	
    </body>
</html>