
<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    date_default_timezone_set('Canada/Atlantic'); 
    $currentTime = date('d-m-Y h:i:s A', time());

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $contactno = $_POST['contactno'];
        $id = intval($_GET['id']);
        $sql = mysqli_query($con, "update users set name='$name',contactno='$contactno' where id='$id'");
        $_SESSION['msg'] = "User Updated !!";
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Admin| User</title>
            <link type="text/css" href="assets/css/bootstrap.min.css" rel="stylesheet">
            <link type="text/css" href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
            <link type="text/css" href="assets/css/theme.css" rel="stylesheet">
            <link type="text/css" href="assets/css/font-awesome.css" rel="stylesheet">
            <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
        </head>
        <body>
            <?php include('include/header.php'); ?>

            <div class="wrapper">
                <div class="container">
                    <div class="row">
                        <?php include('include/sidebar.php'); ?>				
                        <div class="span9">
                            <div class="content">

                                <div class="module">
                                    <div class="module-head">
                                        <h3>User</h3>
                                    </div>
                                    <div class="module-body">

                                        <?php if (isset($_POST['submit'])) {
                                            ?>
                                            <div class="alert alert-success">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <strong>Well done!</strong>	<?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?>
                                            </div>
                                        <?php } ?>


                                        <br />

                                        <form class="form-horizontal row-fluid" name="Category" method="post" >
                                            <?php
                                            $id = intval($_GET['id']);
                                            $query = mysqli_query($con, "select * from users where id='$id'");
                                            while ($row = mysqli_fetch_array($query)) {
                                                ?>									


                                                <div class="control-group">
                                                    <label class="control-label" for="basicinput">Name</label>
                                                    <div class="controls">
                                                        <input type="text" name="name"  placeholder="Enter Name" class="span8 tip" value="<?php echo  htmlentities($row['name']);?>" required>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="basicinput">Email</label>
                                                    <div class="controls">
                                                        <input type="text" name="email"  placeholder="Enter Email" class="span8 tip" value="<?php echo  htmlentities($row['email']);?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="basicinput">Contact No</label>
                                                    <div class="controls">
                                                        <input type="number" name="contactno"  placeholder="Enter Contact No" class="span8 tip" value="<?php echo  htmlentities($row['contactno']);?>" required>
                                                    </div>
                                                </div>
                                            <?php } ?>	

                                            <div class="control-group">
                                                <div class="controls">
                                                    <button type="submit" name="submit" class="btn">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>






                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('include/footer.php'); ?>

            <script src="assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
            <script src="assets/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
            <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
        </body>
    <?php } ?>