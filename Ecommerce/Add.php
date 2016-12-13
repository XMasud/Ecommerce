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
        <title></title>
    </head>
    <body>
        <div id='AdminGroupBtn'><div class='btn-group'>
                <a href='MyAcc.php'><button name='Profile' type='button' class='btn btn-primary'>Profile</button></a>
                <a href='MyAcc.php?AdminEdit=$user_User>'><button name='Edit' type='button' class='btn btn-primary'>Edit</button></a>
                <a href='MyAcc.php?viewUser=$user_User'><button name='ViewUser' type='button' class='btn btn-primary'>View Customer</button></a>
                <a href='MyAcc.php?userShopInfo=$user_User'><button name='Shoppinginfo' type='button' class='btn btn-primary'>View Order</button></a>
                <a href='MyAcc.php?addProduct=$user_User'><button name='AddProduct' type='button' class='btn btn-primary'>Add Product</button></a>
                
                <a href='MyAcc.php?adminID=$user_User'><button name='Logout' type='button' class='btn btn-primary'>Log Out</button></a></a>
            </div></div>

        <form action="Add.php" method="post">

            <select name="com">
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
            <input type="submit" name="com2" value="View">

        </form>
        <form method="post" action="Add.php">
            <button type="submit" name="Del">Delete</button>

        </form>


    </body>
</html>
<?php
if (isset($_POST['com2'])) {
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
			<div id='imgView' style='float:left;margin-top:30px;'>
				<img src='admin_area/product_images/$Pro_image' height='90px' width='100px'>
			</div>

			<div id='infoView' style='float:right;margin-right:950px;'>
				<p>Title:<b>$Pro_title</b></p>
				<p>Category:<b>$Cat</b></p>
				<p>Brand:<b>$Brand</b></p>
				<p>Price:<b>$Pro_price</b></p>
			</div>
		";
}
if (isset($_POST['Del'])) {
    $Delete_Key = $_SESSION['key'];

    $get_Del = "DELETE FROM products WHERE product_id='$Delete_Key'";
    $run_Del = mysqli_query($con, $get_Del);

    if ($run_Del) {
        echo"<script>alert('This product is delete!');</script>";
    }
}
?>