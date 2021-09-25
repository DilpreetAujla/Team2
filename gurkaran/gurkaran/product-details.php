<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (isset($_GET['action']) && $_GET['action'] == "add") {
    $id = intval($_GET['id']);
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
    } else {
        $sql_p = "SELECT * FROM products WHERE id={$id}";
        $query_p = mysqli_query($con, $sql_p);
        if (mysqli_num_rows($query_p) != 0) {
            $row_p = mysqli_fetch_array($query_p);
            $price = $row_p['discount'] ? $row_p['productPrice'] - (($row_p['productPrice'] / 100) * $row_p['discount']) : htmlentities($row_p['productPrice']);
            $_SESSION['cart'][$row_p['id']] = array("quantity" => $_GET['qty'], "price" => $price);
            echo "<script>alert('Product has been added to the cart')</script>";
            echo "<script type='text/javascript'> document.location ='my-cart.php'; </script>";
        } else {
            $message = "Product ID is invalid";
        }
    }
}
$pid = intval($_GET['pid']);
if (isset($_GET['pid']) && $_GET['action'] == "wishlist") {
    if (strlen($_SESSION['login']) == 0) {
        header('location:login.php');
    } else {
        mysqli_query($con, "insert into wishlist(userId,productId) values('" . $_SESSION['id'] . "','$pid')");
        echo "<script>alert('Product aaded in wishlist');</script>";
        header('location:my-wishlist.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <title>Product Details</title>
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

        <header class="header-style-1">

            <!-- ============================================== TOP MENU ============================================== -->
            <?php include('includes/top-header.php'); ?>
            <!-- ============================================== TOP MENU : END ============================================== -->
            <?php include('includes/main-header.php'); ?>
            <!-- ============================================== NAVBAR ============================================== -->
            <?php include('includes/menu-bar.php'); ?>
            <!-- ============================================== NAVBAR : END ============================================== -->

        </header>

        <!-- ============================================== HEADER : END ============================================== -->
        <div class="breadcrumb">
            <div class="container">
                <div class="breadcrumb-inner">
                    <?php
                    $ret = mysqli_query($con, "select category.categoryName as catname,subCategory.subcategory as subcatname,products.productName as pname from products join category on category.id=products.category join subcategory on subcategory.id=products.subCategory where products.id='$pid'");
                    while ($rw = mysqli_fetch_array($ret)) {
                        ?>


                        <ul class="list-inline list-unstyled">
                            <li><a href="index.php">Home</a></li>
                            <li><?php echo htmlentities($rw['catname']); ?></a></li>
                            <li><?php echo htmlentities($rw['subcatname']); ?></li>
                            <li class='active'><?php echo htmlentities($rw['pname']); ?></li>
                        </ul>
                    <?php } ?>
                </div><!-- /.breadcrumb-inner -->
            </div><!-- /.container -->
        </div><!-- /.breadcrumb -->
        <div class="body-content outer-top-xs">
            <div class='container'>
                <div class='row single-product outer-bottom-sm '>
                    <div class='col-md-3 sidebar'>
                        <div class="sidebar-module-container">


                            <!-- ==============================================CATEGORY============================================== -->
                            <div class="sidebar-widget outer-bottom-xs wow fadeInUp">
                                <h3 class="section-title">Category</h3>
                                <div class="sidebar-widget-body m-t-10">
                                    <div class="accordion">

                                        <?php
                                        $sql = mysqli_query($con, "select id,categoryName  from category");
                                        while ($row = mysqli_fetch_array($sql)) {
                                            ?>
                                            <div class="accordion-group">
                                                <div class="accordion-heading">
                                                    <a href="category.php?cid=<?php echo $row['id']; ?>"  class="accordion-toggle collapsed">
                                                        <?php echo $row['categoryName']; ?>
                                                    </a>
                                                </div>

                                            </div>
                                        <?php } ?>
                                    </div>



                                    <div class="widget-header m-t-20">
                                    <h4 class="widget-title">Brand</h4>
                                </div>
                                <div class="sidebar-widget-body m-t-10">
                                    <?php
                                    $sql = mysqli_query($con, "select id,brandName from brand");
                                    while ($row = mysqli_fetch_array($sql)) {
                                        ?>
                                        <div class="accordion">
                                            <div class="accordion-group">
                                                <div class="accordion-heading">
                                                    <a href="brand.php?bid=<?php echo $row['id']; ?>"  class="accordion-toggle collapsed">
                                                        <?php echo $row['brandName']; ?>
                                                    </a>
                                                </div>  
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div><!-- /.sidebar-widget-body -->




                                </div>
                            </div>
                            <!-- ============================================== CATEGORY : END ============================================== -->


                            <!-- ============================================== COLOR: END ============================================== -->
                        </div>
                    </div><!-- /.sidebar -->
                    <?php
                    $ret = mysqli_query($con, "select * from products where id='$pid'");
                    while ($row = mysqli_fetch_array($ret)) {
                        ?>


                        <div class='col-md-9'>
                            <div class="row  wow fadeInUp">
                                <div class="col-xs-12 col-sm-6 col-md-5 gallery-holder">
                                    <div class="product-item-holder size-big single-product-gallery small-gallery">

                                        <div id="owl-single-product">

                                            <div class="single-product-gallery-item" id="slide1">
                                                <img class="img-responsive" alt="" src="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" width="370" height="350" />
                                            </div>




                                            <div class="single-product-gallery-item" id="slide1">
                                                <img class="img-responsive" alt="" src="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" width="370" height="350" />

                                            </div><!-- /.single-product-gallery-item -->

                                            <div class="single-product-gallery-item" id="slide2">
                                                <img class="img-responsive" alt="" src="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage2']); ?>" />

                                            </div><!-- /.single-product-gallery-item -->

                                            <div class="single-product-gallery-item" id="slide3">
                                                <img class="img-responsive" alt="" src="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage3']); ?>" />

                                            </div>

                                        </div><!-- /.single-product-slider -->


                                        <div class="single-product-gallery-thumbs gallery-thumbs">

                                            <div id="owl-single-product-thumbnails">
                                                <div class="item">
                                                    <a class="horizontal-thumb active" data-target="#owl-single-product" data-slide="1" href="#slide1">
                                                        <img class="img-responsive"  alt="" src="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" />
                                                    </a>
                                                </div>

                                                <div class="item">
                                                    <a class="horizontal-thumb" data-target="#owl-single-product" data-slide="2" href="#slide2">
                                                        <img class="img-responsive" width="85" alt="" src="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage2']); ?>"/>
                                                    </a>
                                                </div>
                                                <div class="item">

                                                    <a class="horizontal-thumb" data-target="#owl-single-product" data-slide="3" href="#slide3">
                                                        <img class="img-responsive" width="85" alt="" src="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage3']); ?>" height="200" />
                                                    </a>
                                                </div>




                                            </div><!-- /#owl-single-product-thumbnails -->



                                        </div>

                                    </div>
                                </div>     			




                                <div class='col-sm-6 col-md-7 product-info-block'>
                                    <div class="product-info">
                                        <h1 class="name"><?php echo htmlentities($row['productName']); ?></h1>
                                        <div class="stock-container info-container m-t-10">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="stock-box">
                                                        <span class="label">Product Brand :</span>
                                                    </div>	
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="stock-box">
                                                        <span class="value"><?php echo htmlentities($row['productCompany']); ?></span>
                                                    </div>	
                                                </div>
                                            </div><!-- /.row -->	
                                        </div>


                                        <div class="stock-container info-container m-t-10">	
                                        </div>

                                        <div class="price-container info-container m-t-20">
                                            <div class="row">


                                                <div class="col-sm-6">
                                                    <?php
                                                    if ($row['discount']) {
                                                        ?>
                                                        <span class = "offer-badge position-static"><?php echo $row['discount']; ?>% off</span>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="price-box">
                                                        <span class="price">
                                                            $ <?php echo $row['discount'] ? $row['productPrice'] - (($row['productPrice'] / 100) * $row['discount']) : htmlentities($row['productPrice']); ?>
                                                        </span>
                                                    </div>
                                                    <div class="product-price">	
                                                        <p>
                                                            <?php
                                                            if ($row['discount']) {
                                                                ?>
                                                                Original Price: $ <?php echo $row['productPrice']; ?>
                                                                <?php
                                                            }
                                                            ?>
                                                        </p>
                                                    </div>
                                                </div>




                                                <div class="col-sm-6">
                                                    <div class="favorite-button m-t-10">
                                                        <a class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Wishlist" href="product-details.php?pid=<?php echo htmlentities($row['id']) ?>&&action=wishlist">
                                                            <i class="fa fa-heart"></i>
                                                        </a>

                                                        </a>
                                                    </div>
                                                </div>

                                            </div><!-- /.row -->
                                        </div><!-- /.price-container -->






                                        <div class="quantity-container info-container">
                                            <form>
                                                <div class="row">

                                                    <div class="col-sm-2">
                                                        <span class="label">Qty :</span>
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <div class="cart-quantity">
                                                            <div class="quant-input">
                                                                <div class="arrows">
                                                                    <div class="arrow plus gradient"><span class="ir"><i class="icon fa fa-sort-asc"></i></span></div>
                                                                    <div class="arrow minus gradient"><span class="ir"><i class="icon fa fa-sort-desc"></i></span></div>
                                                                </div>
                                                                <input type="text" value="1" min="1" name="qty" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-7">
                                                        <input type="hidden" value="<?php echo $row['id']; ?>" name="id" />
                                                        <input type="hidden" value="add" name="action" />
                                                        <button type="submit" class="btn btn-primary" name="addtocart"><i class="fa fa-shopping-cart inner-right-vs"></i> ADD TO CART</button>										
                                                    </div>


                                                </div><!-- /.row -->
                                            </form>
                                        </div><!-- /.quantity-container -->

                                        <div class="product-social-link m-t-20 text-right">
                                            <span class="social-label">Share :</span>
                                            <div class="social-icons">
                                                <ul class="list-inline">
                                                    <li><a class="fa fa-facebook" href="http://facebook.com/transvelo"></a></li>
                                                    <li><a class="fa fa-twitter" href="#"></a></li>
                                                    <li><a class="fa fa-linkedin" href="#"></a></li>
                                                    <li><a class="fa fa-rss" href="#"></a></li>
                                                    <li><a class="fa fa-pinterest" href="#"></a></li>
                                                </ul><!-- /.social-icons -->
                                            </div>
                                        </div>




                                    </div><!-- /.product-info -->
                                </div><!-- /.col-sm-7 -->
                            </div><!-- /.row -->


                            <div class="product-tabs inner-bottom-xs  wow fadeInUp">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <ul id="product-tabs" class="nav nav-tabs nav-tab-cell">
                                            <li class="active"><a data-toggle="tab" href="#description">DESCRIPTION</a></li>
                                        </ul><!-- /.nav-tabs #product-tabs -->
                                    </div>
                                    <div class="col-sm-9">

                                        <div class="tab-content">

                                            <div id="description" class="tab-pane in active">
                                                <div class="product-tab">
                                                    <p class="text"><?php echo $row['productDescription']; ?></p>
                                                </div>	
                                            </div><!-- /.tab-pane -->
                                        </div><!-- /.tab-content -->
                                    </div><!-- /.col -->
                                </div><!-- /.row -->
                            </div><!-- /.product-tabs -->

                            <?php
                            $cid = $row['category'];
                            $subcid = $row['subCategory'];
                        }
                        ?>
                        <!-- ============================================== UPSELL PRODUCTS ============================================== -->
                        <section class="section featured-product wow fadeInUp">
                            <h3 class="section-title">Realted Products </h3>
                            <div class="owl-carousel home-owl-carousel upsell-product custom-carousel owl-theme outer-top-xs">

                                <?php
                                $qry = mysqli_query($con, "select * from products where  category='$cid'");
                                while ($rw = mysqli_fetch_array($qry)) {
                                    ?>	


                                    <div class="item item-carousel">
                                        <div class="products">
                                            <div class="product">		
                                                <div class="product-image">
                                                    <div class="image">
                                                        <a href="product-details.php?pid=<?php echo htmlentities($rw['id']); ?>"><img  src="admin/productimages/<?php echo htmlentities($rw['id']); ?>/<?php echo htmlentities($rw['productImage1']); ?>" width="150" height="240" alt=""></a>
                                                    </div><!-- /.image -->			


                                                </div><!-- /.product-image -->


                                                <div class="product-info text-left">
                                                    <h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($rw['id']); ?>"><?php echo htmlentities($rw['productName']); ?></a></h3>
                                                    <div class="rating rateit-small"></div>
                                                    <div class="description"></div>

                                                    <div class="product-price">	
                                                        <span class="price">
                                                            $<?php echo htmlentities($rw['productPrice']); ?>			</span>


                                                    </div><!-- /.product-price -->

                                                </div><!-- /.product-info -->
                                                <div class="cart clearfix animate-effect">
                                                    <div class="action">
                                                        <ul class="list-unstyled">
                                                            <li class="add-cart-button btn-group">
                                                                <button class="btn btn-primary icon" data-toggle="dropdown" type="button">
                                                                    <i class="fa fa-shopping-cart"></i>													
                                                                </button>
                                                                <a href="product-details.php?page=product&action=add&id=<?php echo $rw['id']; ?>" class="lnk btn btn-primary">Add to cart</a>

                                                            </li>


                                                        </ul>
                                                    </div><!-- /.action -->
                                                </div><!-- /.cart -->
                                            </div><!-- /.product -->

                                        </div><!-- /.products -->
                                    </div><!-- /.item -->
                                <?php } ?>


                            </div><!-- /.home-owl-carousel -->
                        </section><!-- /.section -->


                        <!-- ============================================== UPSELL PRODUCTS : END ============================================== -->

                    </div><!-- /.col -->
                    <div class="clearfix"></div>
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