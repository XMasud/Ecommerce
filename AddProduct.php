<!DOCTYPE html>
<?php
session_start();
include("functions/functions.php");

$username = $_SESSION['sess_Username'];

$get_user_pro = "select * from userinfo where Username='$username'";

$run_user_pro = mysqli_query($con, $get_user_pro);

while ($row_user_pro = mysqli_fetch_array($run_user_pro)) {

    $user_User = $row_user_pro['Username'];
}
?>
<html>
    <head>
        <title>Add Product</title>
        <link rel="icon" href="images/favicon.PNG" type="image/x-icon"/>
        <link rel="stylesheet" type="text/css" href="styles/style.css">
        <link href="styles/bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <!--Bootstrap-->
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    </head>
    <body>
        <!--Main content start-->
        <div class="main_wrapper">


            <!--Navigation start-->
            <div class="menubar">
                <ul id="menu">
                    <li><a href="index.php">Home</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Brands<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <ul id="cats">
                                <?php getBrands(); ?>
                            </ul>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Categories<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <ul id="cats">
                                <?php getCats(); ?>
                            </ul>
                        </ul>
                    </li>
                    <li><a style="background-color: #FF0066;border-radius: 10px;color:white;" href="MyAcc.php">My Account</a></li>
                    <li><a href="signup.php">Sign Up</a></li>
                    <li><a href="" id="myacc" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Shopping Cart</a></li>

                </ul>

                <!-- Modal -->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div id="modelcon" class="modal-content">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Your Shopping Cart</h4>
                            </div>

                            <div class="modal-body">
                                <?php Shopping_Fun(); ?>
                                <?php update(); ?>

                                <span style="font-size:30px;padding:5px 5px;margin-right:50px;">
                                    <b style="margin-right:90px;margin-left:30px;">No.</b>
                                    <b style="margin-right:90px;">Item Name</b>
                                    <b style="margin-right:60px;">Price</b>
                                </span>

                                <?php viewItem(); ?>

                            </div>

                        </div>
                    </div>
                </div>
                <!-- Modal -->

                <div id="search_form">
                    <form method="GET" action="results.php">
                        <input name="us" type="search" class="form-control" id="usrs" placeholder="Search Text Here" required>
                        <input id="srcBtn" class="btn btn-info" type="submit" name="sub" value="Search"/>
                    </form>
                </div>

            </div>
            <!--Navigation end-->

            <!--Main wrapper content start-->
            <div class="content_wrapper">

                <div id="content_area">
                    <!--fffffffffffffffffffffffffffffffffffffffffffffffffffffff-->
                    <div id="profile_page">
                        <div id="AdminGroupBtn"><div class="btn-group">
                                <a href="MyAcc.php"><button name="Profile" type="button" class="btn btn-primary">Profile</button></a>
                                <a href="MyAcc.php?AdminEdit=$user_User"><button name="Edit" type="button" class="btn btn-primary">Edit</button></a>
                                <a href="MyAcc.php?viewUser=$user_User"><button name="ViewUser" type="button" class="btn btn-primary">View Customer</button></a>
                                <a href="MyAcc.php?userShopInfo=$user_User"><button name="Shoppinginfo" type="button" class="btn btn-primary">View Order</button></a>
                                <a href="MyAcc.php?addProduct=$user_User"><button name="AddProduct" type="button" class="btn btn-primary">Product</button></a>
                                <a href="MyAcc.php?adminID=$user_User"><button name="Logout" type="button" class="btn btn-primary">Log Out</button></a></a>
                            </div></div>

                        <form method="post" action="AddProduct.php" enctype="multipart/form-data">
                            <table style="color:black;margin-left:45px;;"  align="center" width="650" border="2">
                                <tr align="center">
                                    <td colspan="7" style="color:white;"><h2>Add a New Product</h2></td>
                                </tr>
                                <div style="margin-top:10px;">
                                    <tr>
                                        <td align="right" ><b style="color:white;margin-top:10px;">Product Title:</b></td>
                                        <td><input type="text" name="product_title" placeholder="Write" size="40" required/></td>
                                    </tr>
                                </div>
                                <div style="margin-top:10px;">
                                    <tr>
                                        <td align="right" ><b style="color:white;">Product Category:</b></td>
                                        <td>
                                            <select name="product_cat" required>
                                                <option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Select a category&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                                <?php
                                                $get_cats = "select * from categories";

                                                $run_cats = mysqli_query($con, $get_cats);

                                                while ($row_cats = mysqli_fetch_array($run_cats)) {

                                                    $cat_id = $row_cats['cat_id'];
                                                    $cat_title = $row_cats['cat_title'];

                                                    echo "<option value='$cat_id'>$cat_title</option>";
                                                }
                                                ?>

                                            </select>
                                        </td>
                                    </tr>
                                </div>
                                <tr>
                                    <td align="right" ><b style="color:white;">Product Brand:</b></td>
                                    <td>
                                        <select name="product_brand" required>
                                            <option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Select a brand&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                            <?php
                                            $get_cats = "select * from brands";

                                            $run_cats = mysqli_query($con, $get_cats);

                                            while ($row_brands = mysqli_fetch_array($run_cats)) {

                                                $brand_id = $row_brands['brand_id'];
                                                $brand_title = $row_brands['brand_title'];
                                                echo "<option value='$brand_id'>$brand_title</option>";
                                            }
                                            ?>
                                        </select>

                                    </td>
                                </tr>
                                <tr>
                                    <td align="right"><b style="color:white;">Product Image:</b></td>
                                    <td><input type="file" name="product_image" required/></td>
                                </tr>
                                <tr>
                                    <td align="right" ><b style="color:white;">Product Price:</b></td>
                                    <td><input type="text" name="product_price" size="40" placeholder="Write" required/></td>
                                </tr>
                                <tr>
                                    <td align="right" ><b style="color:white;">Product Description:</b></td>
                                    <td style="margin-bottom:20px;"><textarea name="product_desc" cols="50" rows="8" ></textarea></td>
                                </tr>
                                <tr>
                                    <td align="right" ><b style="color:white;">Product Keywords:</b></td>
                                    <td><input type="text" name="product_keywords" size="40" placeholder="Write"  required/></td>
                                </tr>
                            </table>
                            <button type="submit" name="AdminSubmitEdit" class="btn btn-primary" id="AddSubmit">Add Product</button>
                        </form>



                        <form method="post" action="AddProduct.php" enctype="multipart/form-data">
                            <table style="color:black;margin-left:45px;margin-top:-20px;"  align="center" width="650" border="2">
                                <tr align="center">
                                    <td colspan="7" style="color:white;"><h2>Delete a Product</h2></td>
                                </tr>
                                </div>
                            </table>
                            <select name="com" class="form-control" id="sel1">
                                <option>Select A Product</option>
                                <?php
                                $m = 1;
                                $get_cats = "select * from products";

                                $run_cats = mysqli_query($con, $get_cats);

                                while ($row_brands = mysqli_fetch_array($run_cats)) {

                                    $pro_id = $row_brands['product_id'];
                                    $pro_title = $row_brands['product_title'];
                                    echo "<option value='$pro_id'>$m. $pro_title</option>";
                                    $m++;
                                }
                                ?>
                            </select>
                            <div style="margin-left:70px;">
                                <button type="submit" name="ViewPro" class="btn btn-primary" id="AddSubmit">View Product</button>
                            </div>

                        </form>
                        <form method="post" action="AddProduct.php">
                            <div style="margin-left:-150px;margin-top:50px;">
                                <button type="submit" name="Del" class="btn btn-primary" id="AddSubmit">Delete</button>
                            </div>
                        </form>



                    </div>
                </div>

            </div>
            <!--Main wrapper content end-->

            <div class="footer">
                <h4 style="text-align:center;padding-top:25px;">&copy; copyright SHFN Online Shop 2015</h4>
            </div>
        </div>
        <!--Main content end-->

    </body>
</html>
<?php
///Add product
if (isset($_POST['AdminSubmitEdit'])) {

    //getting the text data from the field
    $product_title = $_POST['product_title'];
    $product_cat = $_POST['product_cat'];
    $product_brand = $_POST['product_brand'];
    $product_price = $_POST['product_price'];
    $product_desc = $_POST['product_desc'];
    $product_keywords = $_POST['product_keywords'];

    //getting the image from the field
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp = $_FILES['product_image']['tmp_name'];

    move_uploaded_file($product_image_tmp, "admin_area/product_images/$product_image");

    $insert_product = "insert into products (product_cat,product_brand,product_title,product_price,product_desc,product_image,product_keywords) values 
		('$product_cat','$product_brand','$product_title','$product_price','$product_desc','$product_image','$product_keywords')";

    $insert_pro = mysqli_query($con, $insert_product);

    if ($insert_pro) {
        echo "<script>alert('Product added successfully!')</script>";
        echo "<script>window.open('AddProduct.php','_self')</script>";
    }
}

//View Product
if (isset($_POST['ViewPro'])) {
    $a = $_POST['com'];
    $get_target = "select * from products where product_id='$a'";

    $run_target = mysqli_query($con, $get_target);

    while ($row_target = mysqli_fetch_array($run_target)) {

        $_SESSION['key'] = $row_target['product_id'];
        $Pro_title = $row_target['product_title'];
        $Pro_cat = $row_target['product_cat'];
        $Pro_brand = $row_target['product_brand'];
        $Pro_price = $row_target['product_price'];
        $Pro_image = $row_target['product_image'];
    }

    $get_cat = "select * from categories where cat_id='$Pro_cat'";
    $run_cat = mysqli_query($con, $get_cat);
    while ($row_cat = mysqli_fetch_array($run_cat)) {
        $Cat = $row_cat['cat_title'];
    }


    $get_brand = "select * from brands where brand_id='$Pro_brand'";
    $run_brand = mysqli_query($con, $get_brand);
    while ($row_brand = mysqli_fetch_array($run_brand)) {
        $Brand = $row_brand['brand_title'];
    }


    echo "
			<div style='margin-top:-300px;margin-left:220px;'>
				<div id='imgView' style='float:left;margin-left:110px;border:3px solid black'>
					<img src='admin_area/product_images/$Pro_image' height='130px' width='150px'>
				</div>

				<div id='infoView' style='float:right;color:white;margin-right:600px;'>
					<p>Title: <b> $Pro_title</b></p>
					<p>Category: <b> $Cat</b></p>
					<p>Brand: <b> $Brand</b></p>
					<p>Price: <b> $Pro_price</b></p>
				</div>
			</div>
		";
}

//delete product
if (isset($_POST['Del'])) {
    $Delete_Key = $_SESSION['key'];

    $get_Del = "DELETE FROM products WHERE product_id='$Delete_Key'";
    $run_Del = mysqli_query($con, $get_Del);

    if ($run_Del) {
        echo"<script>alert('This product is delete!');</script>";
        echo "<script>window.open('AddProduct.php','_self')</script>";
    }
}
?>