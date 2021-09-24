<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (isset($_POST['submit'])) {
    if (!empty($_SESSION['cart'])) {
        foreach ($_POST['quantity'] as $key => $val) {
            if ($val == 0) {
                unset($_SESSION['cart'][$key]);
            } else {
                $_SESSION['cart'][$key]['quantity'] = $val;
            }
        }
        echo "<script>alert('Your Cart has been Updated');</script>";
    }
}
// Code for Remove a Product from Cart
if (isset($_POST['remove_code'])) {

    if (!empty($_SESSION['cart'])) {
        foreach ($_POST['remove_code'] as $key) {

            unset($_SESSION['cart'][$key]);
        }
        echo "<script>alert('Your Cart has been Updated');</script>";
    }
}
// code for insert product in order table


if (isset($_POST['ordersubmit'])) {

    if (strlen($_SESSION['login']) == 0) {
        header('location:login.php');
    } else {

        $baddress = $_POST['billingaddress'];
        $bstate = $_POST['bilingstate'];
        $bcity = $_POST['billingcity'];
        $bpincode = $_POST['billingpincode'];

        $billingAddress = $baddress . ', ' . $bstate . ', ' . $bcity . ' ' . $bpincode;

        $saddress = $_POST['shippingaddress'];
        $sstate = $_POST['shippingstate'];
        $scity = $_POST['shippingcity'];
        $spincode = $_POST['shippingpincode'];

        $shippingAddress = $saddress . ', ' . $sstate . ', ' . $scity . ' ' . $spincode;
        foreach ($_SESSION['cart'] as $key => $item) {
            $val34 = $item['quantity'];
            mysqli_query($con, "insert into orders(userId,productId,quantity, shipping_address, billing_address) values('" . $_SESSION['id'] . "','$key','$val34', '$shippingAddress', '$billingAddress')");
            header('location:payment-method.php');
        }
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

        <title>My Cart</title>
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

        <!-- HTML5 elements and media queries Support for IE8 : HTML5 shim and Respond.js -->
        <!--[if lt IE 9]>
                <script src="assets/js/html5shiv.js"></script>
                <script src="assets/js/respond.min.js"></script>
        <![endif]-->

    </head>
    <body class="cnt-home">



        <!-- ============================================== HEADER ============================================== -->
        <header class="header-style-1">
            <?php include('includes/top-header.php'); ?>
            <?php include('includes/main-header.php'); ?>
            <?php include('includes/menu-bar.php'); ?>
        </header>
        <!-- ============================================== HEADER : END ============================================== -->
        <div class="breadcrumb">
            <div class="container">
                <div class="breadcrumb-inner">
                    <ul class="list-inline list-unstyled">
                        <li><a href="#">Home</a></li>
                        <li class='active'>Shopping Cart</li>
                    </ul>
                </div><!-- /.breadcrumb-inner -->
            </div><!-- /.container -->
        </div><!-- /.breadcrumb -->

        <div class="body-content outer-top-xs">
            <div class="container">
                <div class="row inner-bottom-sm">
                    <div class="shopping-cart">
                        <div class="col-md-12 col-sm-12 shopping-cart-table ">
                            <div class="table-responsive">
                                <form name="cart" method="post">
                                    <?php
                                    if (!empty($_SESSION['cart'])) {
                                        ?>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="cart-romove item">Remove</th>
                                                    <th class="cart-description item">Image</th>
                                                    <th class="cart-product-name item">Product Name</th>

                                                    <th class="cart-qty item">Quantity</th>
                                                    <th class="cart-sub-total item">Price Per unit</th>
                                                    <th class="cart-total last-item">Grandtotal</th>
                                                </tr>
                                            </thead><!-- /thead -->
                                            <tfoot>
                                                <tr>
                                                    <td colspan="7">
                                                        <div class="shopping-cart-btn">
                                                            <span class="">
                                                                <a href="index.php" class="btn btn-upper btn-primary outer-left-xs" id="3654444">Continue Shopping</a>
                                                                <input type="submit" name="submit" value="Update shopping cart" class="btn btn-upper btn-primary pull-right outer-right-xs">
                                                            </span>
                                                        </div><!-- /.shopping-cart-btn -->
                                                    </td>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                $pdtid = array();
                                                $sql = "SELECT * FROM products WHERE id IN(";
                                                foreach ($_SESSION['cart'] as $id => $value) {
                                                    $sql .= $id . ",";
                                                }
                                                $sql = substr($sql, 0, -1) . ") ORDER BY id ASC";
                                                $query = mysqli_query($con, $sql);
                                                $totalprice = 0;
                                                $totalqunty = 0;
                                                if (!empty($query)) {
                                                    while ($row = mysqli_fetch_array($query)) {
                                                        $price = $row['discount'] ? $row['productPrice'] - (($row['productPrice'] / 100) * $row['discount']) : htmlentities($row['productPrice']);
                                                        $quantity = $_SESSION['cart'][$row['id']]['quantity'];
                                                        $subtotal = $_SESSION['cart'][$row['id']]['quantity'] * $price + $row['shippingCharge'];
                                                        $totalprice += $subtotal;
                                                        $_SESSION['qnty'] = $totalqunty += $quantity;

                                                        array_push($pdtid, $row['id']);
                                                        ?>

                                                        <tr>
                                                            <td class="romove-item"><input type="checkbox" name="remove_code[]" value="<?php echo htmlentities($row['id']); ?>" /></td>
                                                            <td class="cart-image">
                                                                <a class="entry-thumbnail" href="detail.html">
                                                                    <img src="admin/productimages/<?php echo $row['id']; ?>/<?php echo $row['productImage1']; ?>" alt="" width="114" height="146">
                                                                </a>
                                                            </td>
                                                            <td class="cart-product-name-info">
                                                                <h4 class='cart-product-description'><a href="product-details.php?pid=<?php echo htmlentities($pd = $row['id']); ?>" ><?php
                                                                        echo $row['productName'];

                                                                        $_SESSION['sid'] = $pd;
                                                                        ?></a></h4>
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <div class="rating rateit-small"></div>
                                                                    </div>
                                                                </div><!-- /.row -->

                                                            </td>
                                                            <td class="cart-product-quantity">
                                                                <div class="quant-input">
                                                                    <div class="arrows">
                                                                        <div class="arrow plus gradient"><span class="ir"><i class="icon fa fa-sort-asc"></i></span></div>
                                                                        <div class="arrow minus gradient"><span class="ir"><i class="icon fa fa-sort-desc"></i></span></div>
                                                                    </div>
                                                                    <input type="text" value="<?php echo $_SESSION['cart'][$row['id']]['quantity']; ?>" name="quantity[<?php echo $row['id']; ?>]">

                                                                </div>
                                                            </td>
                                                            <td class="cart-product-sub-total"><span class="cart-sub-total-price"><?php echo "$" . " " . $price; ?>.00</span></td>

                                                            <td class="cart-product-grand-total"><span class="cart-grand-total-price"><?php echo ($_SESSION['cart'][$row['id']]['quantity'] * $price); ?>.00</span></td>
                                                        </tr>

                                                        <?php
                                                    }
                                                }
                                                $_SESSION['pid'] = $pdtid;
                                                ?>

                                            </tbody><!-- /tbody -->
                                        </table><!-- /table -->
                                    </form>
                                </div>
                            </div><!-- /.shopping-cart-table -->
                            <form name="order" method="post">
                                <div class="col-md-4 col-sm-12 estimate-ship-tax">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <span class="estimate-title">Billing Address</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-group">

                                                        <div class="form-group">
                                                            <label class="info-title" for="Billing Address">Billing Address<span>*</span></label>
                                                            <textarea class="form-control unicase-form-control text-input"  name="billingaddress" required="required"></textarea>
                                                        </div>



                                                        <div class="form-group">
                                                            <label class="info-title" for="Billing Province ">Billing Province  <span>*</span></label>
                                                            <input type="text" class="form-control unicase-form-control text-input" id="bilingstate" name="bilingstate" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="info-title" for="Billing City">Billing City <span>*</span></label>
                                                            <input type="text" class="form-control unicase-form-control text-input" id="billingcity" name="billingcity" required="required">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="info-title" for="Billing Zipcode">Billing Zipcode <span>*</span></label>
                                                            <input type="text" class="form-control unicase-form-control text-input" id="billingpincode" name="billingpincode" required="required">
                                                        </div>

                                                    </div>

                                                </td>
                                            </tr>
                                        </tbody><!-- /tbody -->
                                    </table><!-- /table -->
                                </div>

                                <div class="col-md-4 col-sm-12 estimate-ship-tax">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <span class="estimate-title">Shipping Address</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label class="info-title" for="Shipping Address">Shipping Address<span>*</span></label>
                                                            <textarea class="form-control unicase-form-control text-input"  name="shippingaddress" required="required"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="info-title" for="Billing Province ">Shipping Province  <span>*</span></label>
                                                            <input type="text" class="form-control unicase-form-control text-input" id="shippingstate" name="shippingstate" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="info-title" for="Billing City">Shipping City <span>*</span></label>
                                                            <input type="text" class="form-control unicase-form-control text-input" id="shippingcity" name="shippingcity" required="required">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="info-title" for="Billing Zipcode">Shipping Zipcode <span>*</span></label>
                                                            <input type="text" class="form-control unicase-form-control text-input" id="shippingpincode" name="shippingpincode" required="required">
                                                        </div>

                                                    </div>

                                                </td>
                                            </tr>
                                        </tbody><!-- /tbody -->
                                    </table><!-- /table -->
                                </div>
                                <div class="col-md-4 col-sm-12 cart-shopping-total">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>

                                                    <div class="cart-grand-total">
                                                        Grand Total<span class="inner-left-md">$<?php echo $_SESSION['tp'] = "$totalprice" . ".00"; ?></span>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead><!-- /thead -->
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="cart-checkout-btn pull-right">
                                                        <button type="submit" name="ordersubmit" class="btn btn-primary">PROCCED TO CHEKOUT</button>

                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody><!-- /tbody -->
                                    </table>
                                    <?php
                                } else {
                                    echo "Your shopping Cart is empty";
                                }
                                ?>
                            </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/scripts.js"></script>
    </body>
</html>
