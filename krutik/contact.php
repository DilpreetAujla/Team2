<?php
session_start();
error_reporting(0);
include('includes/config.php');
// Code for sending into db
if (isset($_POST['submit'])) {
    $name = $_POST['message'];
    $email = $_POST['emailid'];
   
  
    $query = mysqli_query($con, "insert into contact(email,msg) values('$email','$name')");
    if ($query) {
        echo "<script>alert('Thanks for your feedback');</script>";
    } else {
        echo "<script>alert('Something wrong !!');</script>";
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
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="keywords" content="MediaCenter, Template, eCommerce">
        <meta name="robots" content="all">

        <title>Shopping Portal about Page</title>

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

    </head>
    <body class="cnt-home">



        <!-- ============================================== HEADER ============================================== -->
        <header class="header-style-1">
<?php include('includes/top-header.php'); ?>
<?php include('includes/main-header.php'); ?>
            <?php include('includes/menu-bar.php'); ?>
        </header>

        <!-- ============================================== HEADER : END ============================================== -->
        <div class="body-content outer-top-xs" id="top-banner-and-menu">
            <div class="container">
                <div class="furniture-container homepage-container">
                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-3 sidebar">
                            <!-- ================================== TOP NAVIGATION ================================== -->

                            <!-- ================================== TOP NAVIGATION : END ================================== -->
                        </div><!-- /.sidemenu-holder -->	

                        <div class="col-xs-12 col-sm-12 col-md-9 homebanner-holder">
                            <!-- ========================================== SECTION – HERO ========================================= -->


                            <!-- ========================================= SECTION – HERO : END ========================================= -->		
                        </div><!-- /.homebanner-holder -->

                    </div><!-- /.row -->

                    <!-- ============================================== SCROLL TABS ============================================== -->
                    <div id="product-tabs-slider" class="scroll-tabs inner-bottom-vs  wow fadeInUp">
                       

                      
                    <img src="assets/images/contact-us.jpg" alt="" width="1200" height="550">
                       
                        
                        <br><br>








           
                        <!-- feedback form -->
                        <div class="col-md-6 col-sm-6 create-new-account">
                            <h2 class="title text-center">Please send us feedback here</h2>
                           
                            <form class="register-form outer-top-xs" role="form" method="post" name="register" onSubmit="return valid();">
                              


                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail2">Email Address <span>*</span></label>
                                    <input type="email" class="form-control unicase-form-control text-input" id="email"  name="emailid" required >
                                    <span id="user-availability-status1" style="font-size:12px;"></span>
                                </div>

                                <div class="form-group">
                                    <label class="info-title" for="message">message <span>*</span></label>
                                    <textarea type="text" class="form-control unicase-form-control text-input" id="message" name="message" rows="7" cols="50" required="required"></textarea>
                                </div>

                                

            

                                <button type="submit" name="submit" class="btn-upper btn btn-primary checkout-page-button" id="submit">Send</button>
                            </form>
                        </div>	
                        <!-- feedback form -->
                       
              


                <div class="col-sm-4">
	    			<div class="contact-info">
	    				<h2 class="title text-center">Contact Information</h2>
	    				<address>
	    					<p>DAKG</p>
							<p>6980 , Domnic avenue </p>
                            <p>Downtown area , G13 2E1</p>
                            <br><br>
							 <p>ph : +1 435 332 332</p>
							<p>mail : dakg.info@gmail.com</p>
	    				</address>
	    				
	    			</div>
    			</div>



                <br><br> <br><br> <br><br> <br><br> <br><br>
                <br><br> <br><br> <br><br> <br><br> <br><br>




                            <div class="tab-pane" id="books">
                                <div class="product-slider">
                                    <div class="owl-carousel home-owl-carousel custom-carousel owl-theme">

                                    </div>
                                </div>
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