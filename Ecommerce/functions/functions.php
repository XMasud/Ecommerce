<?php

$con = mysqli_connect("localhost", "root", "", "ecommerce");

if (mysqli_connect_errno()) {
    echo "The connection was not established " . mysqli_connect_errno();
}

$a = 1;

//Get IP address
function getIp() {

    $ip = $_SERVER['REMOTE_ADDR'];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return $ip;
}

//card function to add item------------------------------------------------------------
function cart() {
    if (isset($_GET['add_card'])) {

        global $con;

        $ip = getIp();
        $pro_id = $_GET['add_card'];

        $check_pro = "select * from cart where ip_add='$ip' AND p_id='$pro_id'";

        $run_check = mysqli_query($con, $check_pro);

        if (mysqli_num_rows($run_check) > 0) {
            echo "<script>alert('Sorry, This product is already added!');</script>";
        } else {
            $insert_pro = "insert into cart (p_id,ip_add) values ('$pro_id','$ip')";
            $run_pro = mysqli_query($con, $insert_pro);
            echo "<script>alert('Product added successfully into cart!');</script>";
        }
    }
}

//show item in cart--------------------------------------------------------------------
function viewItem() {
    global$con;
    $no = 1;
    $items = "";
    $total_cost = 0;
    $ip = getIp();

    $get_cart = "SELECT products.product_title, products.product_price, cart.cart_id
					FROM cart
					INNER JOIN products
					ON cart.p_id=products.product_id
					where ip_add='$ip';";

    $run_cart = mysqli_query($con, $get_cart);

    $count_cart = mysqli_num_rows($run_cart);

    if ($count_cart == 0) {
        echo "<h2 style='text-align:center;color:#B2B2B2;'>Empty Cart</h2>";
    }

    while ($row_cart = mysqli_fetch_array($run_cart)) {
        $cart_id = $row_cart['cart_id'];
        $p_title = $row_cart['product_title'];
        $items.= $p_title . ", ";



        $p_price = $row_cart['product_price'];
        $total_cost+=$p_price;

        //echo "<li><a href='index.php?cat=$cat_id'>$cat_title</a></li>";
        //echo "<li><button type='button' id='sidebarbtn' class='btn btn-success'><a href='index.php?cat=$cat_id'>$cat_title</a></button></li>";

        echo "
					<span style='font-size:30px;padding:5px 5px;margin-right:50px;'>
				          <span style='margin-right:55px;margin-left:30px;'>$no</span>
				          <span style='margin-right:30px;'><input type='text'  size='15' value='$p_title' disabled></span>
				          <span style='margin-right:30px;'><span style='width100px;'>$p_price</span></span>
				          <span ><a href='index.php?cart_id=$cart_id'><button  name='$cart_id' class='btn btn-primary btn-xs'>X</button></a></span>
				          <br/>
			        </span>

			";
        $no++;
    }
    if ($count_cart != 0) {
        echo "
				<p id='total_cost'>Total price: $<b style='color:red;'>$total_cost</b></p>

				<div class='modal-footer'>
					<a href='index.php?ip=$ip&items=$items&total_cost=$total_cost'><button class='btn btn-primary'>Make Order</button></a>        	
				</div>
				
			";
    }


    $no = 0;
}

//updating shopping cart-----------------------------------------------
function update() {
    if (isset($_GET['cart_id'])) {

        $key = $_GET['cart_id'];
        global $con;
        $del_cart = "DELETE FROM cart WHERE cart_id='$key' ";
        $run_del = mysqli_query($con, $del_cart);
    }
}

//shoping order-----------------------------------------------------------------
function Shopping_Fun() {

    if (isset($_GET['ip'])) {
        session_start();
        if (isset($_SESSION['loggedin'])) {
            global $con;

            $date = date("d-m-y");
            $ip = $_GET['ip'];
            $itms = $_GET['items'];
            $total_cost = $_GET['total_cost'];
            $Username = $_SESSION['sess_Username'];


            $get_user_id = "select * from userinfo where Username='$Username'";
            $run_guip = mysqli_query($con, $get_user_id);

            while ($row_usr = mysqli_fetch_array($run_guip)) {
                $get_u_id = $row_usr['User_id'];
            }

            $insert_order = "insert into user_shopping_info (User_id,ip_add,Shoping_items,Shopping_cost,Shopping_date) 
					values ('$get_u_id','$ip','$itms','$total_cost','$date')";



            $run_insertion = mysqli_query($con, $insert_order);
            if ($run_insertion) {
                echo"<script>alert('Make Order successfully!');</script>";
            }
        } else {

            echo"<script>alert('Please Log in first!');</script>";
            echo "<script>window.open('MyAcc.php','_self')</script>";
        }
    }
}

//getting the categories----------------------------------to display---------------------------------------
function getCats() {
    global $con;

    $get_cats = "select * from categories";

    $run_cats = mysqli_query($con, $get_cats);

    while ($row_cats = mysqli_fetch_array($run_cats)) {

        $cat_id = $row_cats['cat_id'];
        $cat_title = $row_cats['cat_title'];

        //echo "<li><a href='index.php?cat=$cat_id'>$cat_title</a></li>";
        echo "<li><button  id='sidebarbtn' class='btn btn-success btn-xs'><a href='index.php?cat=$cat_id'>$cat_title</a></button></li>";
    }
}

///Get Brand to display----------------------------------------------------------------------------------------------
function getBrands() {
    global $con;

    $get_cats = "select * from brands";

    $run_cats = mysqli_query($con, $get_cats);

    while ($row_brands = mysqli_fetch_array($run_cats)) {

        $brand_id = $row_brands['brand_id'];
        $brand_title = $row_brands['brand_title'];

        //echo "<li><a href='#'>$brand_title</a></li>";
        echo "<li><button id='sidebarbtn' class='btn btn-success btn-xs'><a href='index.php?brand=$brand_id'>$brand_title</a></button></li>";
    }
}

//get product  from db-------------------------------------------------------------------------------
function getPro() {
    global $a;

    if ($a == 1) {



        global $con;

        $get_pro = "select * from products order by RAND() LIMIT 0,15";

        $run_pro = mysqli_query($con, $get_pro);

        while ($row_pro = mysqli_fetch_array($run_pro)) {

            $pro_id = $row_pro['product_id'];
            $pro_cat = $row_pro['product_cat'];
            $pro_brand = $row_pro['product_brand'];
            $pro_title = $row_pro['product_title'];
            $pro_price = $row_pro['product_price'];
            $pro_image = $row_pro['product_image'];

            echo "
				<div id='single_product'>
					<h4>$pro_title</h4>
					<a href='details.php?pro_id=$pro_id'><img id='item' src='admin_area/product_images/$pro_image' alt='item' width='110px' height='95px'></a>
					<img class='shadow' src='images/shadow.PNG' alt='sh' width='118px' height='18px'>
					
					<div id='pro_price'>
						<p><b>$ $pro_price</b></p>
					</div>
					
					<div id='pro_add'>
						<a href='index.php?add_card=$pro_id'><button type='button' class='btn btn-primary btn-xs' style='float:right;'>Add to Cart</button></a>
					</div>

				</div>

			";
        }
    }
}

function getCatPro() {


    if (isset($_GET['cat'])) {

        global $a;
        $a = 2;

        $cat_id = $_GET['cat'];

        global $con;

        $get_cat_pro = "select * from products where product_cat='$cat_id'";

        $run_cat_pro = mysqli_query($con, $get_cat_pro);

        $count_cat = mysqli_num_rows($run_cat_pro);

        if ($count_cat == 0) {
            echo "<h2>There is no product in this category!</h2>";
            exit();
        }

        while ($row_cat_pro = mysqli_fetch_array($run_cat_pro)) {

            $pro_id = $row_cat_pro['product_id'];
            $pro_cat = $row_cat_pro['product_cat'];
            $pro_brand = $row_cat_pro['product_brand'];
            $pro_title = $row_cat_pro['product_title'];
            $pro_price = $row_cat_pro['product_price'];
            $pro_image = $row_cat_pro['product_image'];

            echo "
						<div id='single_product'>
							<h4>$pro_title</h4>
							<a href='details.php?pro_id=$pro_id'><img id='item' src='admin_area/product_images/$pro_image' alt='item' width='110px' height='95px'></a>
							<img class='shadow' src='images/shadow.PNG' alt='sh' width='115px' height='18px'>
							
							<div id='pro_price'>
								<p><b>$ $pro_price</b></p>
							</div>
							
							<div id='pro_add'>
								<a href='index.php?add_card=$pro_id'><button type='button' class='btn btn-primary btn-xs' style='float:right;'>Add to Cart</button></a>
							</div>

						</div>

					";
        }
    }
}

function getBrandPro() {

    if (isset($_GET['brand'])) {
        global $a;
        $a = 2;

        $brand_id = $_GET['brand'];

        global $con;

        $get_brand_pro = "select * from products where product_brand='$brand_id'";

        $run_brand_pro = mysqli_query($con, $get_brand_pro);

        $count_brand = mysqli_num_rows($run_brand_pro);

        if ($count_brand == 0) {
            echo "<h2>There is no product in this brand!</h2>";
            exit();
        }

        while ($row_brand_pro = mysqli_fetch_array($run_brand_pro)) {

            $pro_id = $row_brand_pro['product_id'];
            $pro_cat = $row_brand_pro['product_cat'];
            $pro_brand = $row_brand_pro['product_brand'];
            $pro_title = $row_brand_pro['product_title'];
            $pro_price = $row_brand_pro['product_price'];
            $pro_image = $row_brand_pro['product_image'];

            echo "
						<div id='single_product'>
							<h4>$pro_title</h4>
							<a href='details.php?pro_id=$pro_id' ><img id='item' src='admin_area/product_images/$pro_image' alt='item' width='110px' height='95px'></a>
							<img class='shadow' src='images/shadow.PNG' alt='sh' width='115px' height='18px'>
							
							<div id='pro_price'>
								<p><b>$ $pro_price</b></p>
							</div>
							
							<div id='pro_add'>
								<a href='index.php?add_card=$pro_id'><button type='button' class='btn btn-primary btn-xs' style='float:right;'>Add to Cart</button></a>
							</div>

						</div>

					";
        }
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////
//Admin user control panel---------------------------------------------------------------------------
function Admin_profile() {
    if (!isset($_GET['adminID']) && !isset($_GET['userShopInfo']) && !isset($_GET['AdminEdit']) && !isset($_GET['viewUser']) && !isset($_GET['CusProId'])) {
        $username = $_SESSION['sess_Username'];


        global $con;

        $get_user_pro = "select * from userinfo where Username='$username'";

        $run_user_pro = mysqli_query($con, $get_user_pro);

        while ($row_user_pro = mysqli_fetch_array($run_user_pro)) {

            $user_Name = $row_user_pro['Fullname'];
            $user_User = $row_user_pro['Username'];
            $user_Pass = $row_user_pro['Password'];
            $user_Phone = $row_user_pro['Phone'];
            $user_Email = $row_user_pro['Email'];
            $user_Address = $row_user_pro['Address'];
            $user_image = $row_user_pro['User_image'];
        }

        echo "
				<div id='profile_page'>
					<div id='AdminGroupBtn'><div class='btn-group'>
					  <a href='MyAcc.php'><button name='Profile' type='button' class='btn btn-primary'>Profile</button></a>
					  <a href='MyAcc.php?AdminEdit=$user_User'><button name='Edit' type='button' class='btn btn-primary'>Edit</button></a>
					  <a href='MyAcc.php?viewUser=$user_User'><button name='ViewUser' type='button' class='btn btn-primary'>View Customer</button></a>
					  <a href='MyAcc.php?userShopInfo=$user_User'><button name='Shoppinginfo' type='button' class='btn btn-primary'>View Order</button></a>
					  <a href='AddProduct.php'><button name='AddProduct' type='button' class='btn btn-primary'>Product</button></a>
					  
					  <a href='MyAcc.php?adminID=$user_User'><button name='Logout' type='button' class='btn btn-primary'>Log Out</button></a></a>
					</div></div>

					<h4 id='name'>Admin Logged in</h4>
					<h4 id='name'>Welcome, $user_Name</h4>
					
					<div id='profile_pic'>
						<img src='user_img//$user_image' class='img-circle' alt='Cinque Terre' width='160' height='150'>
					</div>
					
					<div id='infotable'>
						<table id='customers'>
							<tr >
						    	<th colspan='2'>User Information</th>
						  	</tr>
						  <tr class='alt'>
						    <td>Name</td>
						    <td>$user_Name</td>
						  </tr>
						  <tr>
						    <td>Username</td>
						    <td>$user_User</td>
						  </tr>
						  <tr class='alt'>
						    <td>Password</td>
						    <td>$user_Pass</td>
						  </tr>
						  <tr>
						    <td>Phone</td>
						    <td>$user_Phone</td>
						  </tr>
						  <tr class='alt'>
						    <td>Email</td>
						    <td>$user_Email</td>
						  </tr>
						  <tr>
						    <td>Address</td>
						    <td>$user_Address</td>
						  </tr>
						</table>

					</div>

					
				</div>
			";
    }
}

function AdminEdit() {
    if (isset($_GET['AdminEdit'])) {

        $username = $_SESSION['sess_Username'];
        global $con;

        $get_user_pro = "select * from userinfo where Username='$username'";

        $run_user_pro = mysqli_query($con, $get_user_pro);

        while ($row_user_pro = mysqli_fetch_array($run_user_pro)) {

            $user_id = $row_user_pro['User_id'];
            $user_Name = $row_user_pro['Fullname'];
            $user_User = $row_user_pro['Username'];
            $user_Pass = $row_user_pro['Password'];
            $user_Phone = $row_user_pro['Phone'];
            $user_Email = $row_user_pro['Email'];
            $user_Address = $row_user_pro['Address'];
            $user_image = $row_user_pro['User_image'];
        }

        echo "
				<div id='profile_page'>
					<div id='AdminGroupBtn'><div class='btn-group'>
					  <a href='MyAcc.php'><button name='Profile' type='button' class='btn btn-primary'>Profile</button></a>
					  <a href='MyAcc.php?AdminEdit=$user_User'><button name='Edit' type='button' class='btn btn-primary'>Edit</button></a>
					  <a href='MyAcc.php?viewUser=$user_User'><button name='ViewUser' type='button' class='btn btn-primary'>View Customer</button></a>
					  <a href='MyAcc.php?userShopInfo=$user_User'><button name='Shoppinginfo' type='button' class='btn btn-primary'>View Order</button></a>
					  <a href='AddProduct.php'><button name='AddProduct' type='button' class='btn btn-primary'>Product</button></a>
					  
					  <a href='MyAcc.php?adminID=$user_User'><button name='Logout' type='button' class='btn btn-primary'>Log Out</button></a></a>
					</div></div>
					
					<form action='MyAcc.php' method='post' >
						<div id='infotable'>
							<table id='customers'>
								<tr >
							    	<th colspan='2'>User Edit Information</th>
							  	</tr>
							  <tr class='alt'>
							    <td>Name</td>
							    <td><div style='vertical-alignment:center'><input name='Name' type='text' size='45' value='$user_Name'></div></td>
							  </tr>
							  <tr>
							    <td>Username</td>
							    <td><div style='vertical-alignment:center'><input name='Username' type='text' size='45' value='$user_User'></div></td>
							  </tr>
							  <tr class='alt'>
							    <td>Password</td>
							    <td><div style='vertical-alignment:center'><input name='Password' type='text' size='45' value='$user_Pass'></div></td>
							  </tr>
							  <tr>
							    <td>Phone</td>
							    <td><div style='vertical-alignment:center'><input name='Phone' type='text' size='45' value='$user_Phone'></div></td>
							  </tr>
							  <tr class='alt'>
							    <td>Email</td>
							    <td><div style='vertical-alignment:center'><input name='Email' type='text' size='45' value='$user_Email'></div></td>
							  </tr>
							  <tr>
							    <td>Address</td>
							    <td><div style='vertical-alignment:center'><textarea name='Address' rows='4' cols='45'>$user_Address</textarea></div></td>
							  </tr>
							</table>
								<button type='submit' name='AdminSubmitEdit' class='btn btn-primary' id='ProfileEditSubmit'>Submit Edit</button>

						</div>
					</form>

				</div>
			";
    }
}

function AdminSubmitEdit() {

    if (isset($_POST['AdminSubmitEdit'])) {

        $username = $_SESSION['sess_Username'];

        $Edit_Name = $_POST['Name'];
        $Edit_Username = $_POST['Username'];
        $Edit_Password = $_POST['Password'];
        $Edit_Phone = $_POST['Phone'];
        $Edit_Email = $_POST['Email'];
        $Edit_Address = $_POST['Address'];

        global $con;



        $edit_user_pro = "UPDATE userinfo
			SET Fullname='$Edit_Name', Username='$Edit_Username', Password='$Edit_Password', Phone='$Edit_Phone', Email='$Edit_Email', Address='$Edit_Address'
			WHERE Username='$username'
			";

        $run_edit_user_pro = mysqli_query($con, $edit_user_pro);

        if ($run_edit_user_pro) {
            echo "<script>alert('Your Profile Edit Successfully!');</script>";
            echo "<script>window.open('MyAcc.php','_self')</script>";
        } else {

            echo "<script>alert('Error occured!');</script>";
            echo "<script>window.open('MyAcc.php','_self')</script>";
        }
    }
}

function ViewCustomer() {
    if (isset($_GET['viewUser'])) {

        $username = $_SESSION['sess_Username'];
        global $con;
        $Customer_id = array(50);
        $Customer_name = array(50);
        $Customer_phone = array(50);
        $Customer_email = array(50);
        $Customer_address = array(50);


        $i = 0;
        $j = 1;

        $get_user_pro = "select * from userinfo where Username='$username'";

        $run_user_pro = mysqli_query($con, $get_user_pro);

        while ($row_user_pro = mysqli_fetch_array($run_user_pro)) {

            $user_id = $row_user_pro['User_id'];
            $user_User = $row_user_pro['Username'];
        }

        $get_user_pro = "select * from userinfo where Username!='$username'";

        $run_user_pro = mysqli_query($con, $get_user_pro);


        while ($row_user_pro = mysqli_fetch_array($run_user_pro)) {

            $Customer_id[$i] = $row_user_pro['User_id'];
            $Customer_name[$i] = $row_user_pro['Fullname'];
            $Customer_phone[$i] = $row_user_pro['Phone'];
            $Customer_email[$i] = $row_user_pro['Email'];
            $Customer_address[$i] = $row_user_pro['Address'];
            $i++;
        }

        echo "
				<div id='profile_page'>
					<div id='AdminGroupBtn'><div class='btn-group'>
					  <a href='MyAcc.php'><button name='Profile' type='button' class='btn btn-primary'>Profile</button></a>
					  <a href='MyAcc.php?AdminEdit=$user_User'><button name='Edit' type='button' class='btn btn-primary'>Edit</button></a>
					  <a href='MyAcc.php?viewUser=$user_User'><button name='ViewUser' type='button' class='btn btn-primary'>View Customer</button></a>
					  <a href='MyAcc.php?userShopInfo=$user_User'><button name='Shoppinginfo' type='button' class='btn btn-primary'>View Order</button></a>
					  <a href='AddProduct.php'><button name='AddProduct' type='button' class='btn btn-primary'>Product</button></a>
					 
					  <a href='MyAcc.php?adminID=$user_User'><button name='Logout' type='button' class='btn btn-primary'>Log Out</button></a></a>
					</div></div>
				

				<div id='shoppinginfo'>
					<table id='User'>
						<tr id='title'>
						    <th colspan='7'>User Shopping Information</th>
						</tr>
						<tr id='title'>
							<td>No</td>
						    <td>Name</td>
						    <td>Phone</td>
						    <td>Email&nbsp;</td>
						    <td>Address</td>
						    <td>Details</td>
						</tr>
					</table>
				</div>
			";

        for ($n = 0; $n < $i; $n++) {

            echo "

				 	<div id='shoppinginfoPrevious'>
				 		<table id='UserPrevious'>
				 			<tr class='alt'>
				 		    	<td>$j</td>
				 		    	<td>&nbsp;$Customer_name[$n]&nbsp;</td>
				 		    	<td>$Customer_phone[$n]</td>
				 		    	<td>$Customer_email[$n]</td>
				 		    	<td>$Customer_address[$n]</td>
				 		    	<td style='margin-top:5px;' height='50px;'><a href='MyAcc.php?CusProId=$Customer_id[$n]'><button  name='Button' class='btn btn-primary btn-xs'>View</button></td>
				 		  	</tr>
				 		</table>
				 	</div>
					

				 	";
            $j++;
        }
        $j = 0;
    }
}

function CustomerProfile() {
    if (isset($_GET['CusProId'])) {
        $username = $_SESSION['sess_Username'];
        $CustomerId = $_GET['CusProId'];


        global $con;

        $get_user_pro = "select * from userinfo where User_id='$CustomerId'";

        $run_user_pro = mysqli_query($con, $get_user_pro);

        while ($row_user_pro = mysqli_fetch_array($run_user_pro)) {

            $user_Name = $row_user_pro['Fullname'];
            $user_User = $row_user_pro['Username'];
            $user_Pass = $row_user_pro['Password'];
            $user_Phone = $row_user_pro['Phone'];
            $user_Email = $row_user_pro['Email'];
            $user_Address = $row_user_pro['Address'];
            $user_image = $row_user_pro['User_image'];
        }

        echo "
				<div id='profile_page'>
					<div id='AdminGroupBtn'><div class='btn-group'>
					  <a href='MyAcc.php'><button name='Profile' type='button' class='btn btn-primary'>Profile</button></a>
					  <a href='MyAcc.php?AdminEdit=$user_Name'><button name='Edit' type='button' class='btn btn-primary'>Edit</button></a>
					  <a href='MyAcc.php?viewUser=$user_Name'><button name='ViewUser' type='button' class='btn btn-primary'>View Customer</button></a>
					  <a href='MyAcc.php?userShopInfo=$user_Name'><button name='Shoppinginfo' type='button' class='btn btn-primary'>View Order</button></a>
					  <a href='AddProduct.php'><button name='AddProduct' type='button' class='btn btn-primary'>Product</button></a>
					 
					  <a href='MyAcc.php?adminID=$user_Name'><button name='Logout' type='button' class='btn btn-primary'>Log Out</button></a></a>
					</div></div>
					<div style='margin-left:350px;margin-top:15px;'><a href='MyAcc.php?viewUser=$user_Name'><button  name='Button' class='btn btn-primary btn-xs'>Back</button></a></div>
					<h4 id='name'>$user_Name</h4>
					
					<div id='profile_pic'>
						<img src='user_img//$user_image' class='img-circle' alt='Cinque Terre' width='160' height='150'>
					</div>
					
					<div id='infotable'>
						<table id='customers'>
							<tr >
						    	<th colspan='2'>User Information</th>
						  	</tr>
						  <tr class='alt'>
						    <td>Name</td>
						    <td>$user_Name</td>
						  </tr>
						  <tr>
						    <td>Username</td>
						    <td>$user_User</td>
						  </tr>
						  <tr class='alt'>
						    <td>Password</td>
						    <td>$user_Pass</td>
						  </tr>
						  <tr>
						    <td>Phone</td>
						    <td>$user_Phone</td>
						  </tr>
						  <tr class='alt'>
						    <td>Email</td>
						    <td>$user_Email</td>
						  </tr>
						  <tr>
						    <td>Address</td>
						    <td>$user_Address</td>
						  </tr>
						</table>

					</div>

					
				</div>
			";
    }
}

function ViewOrder() {
    if (isset($_GET['userShopInfo'])) {

        $username = $_SESSION['sess_Username'];
        global $con;
        $Customer_id = array(50);
        $Shopping_item = array(50);
        $Shopping_cost = array(50);
        $Shopping_date = array(50);
        $Shopping_quantity = array(50);


        $i = 0;
        $j = 1;

        $get_user_pro = "select * from userinfo where Username='$username'";

        $run_user_pro = mysqli_query($con, $get_user_pro);

        while ($row_user_pro = mysqli_fetch_array($run_user_pro)) {

            $user_id = $row_user_pro['User_id'];
            $user_User = $row_user_pro['Username'];
        }


        $get_user_shopping = "select * from user_shopping_info";

        $run_user_shopping = mysqli_query($con, $get_user_shopping);

        while ($row_user_shopping = mysqli_fetch_array($run_user_shopping)) {

            $Customer_id[$i] = $row_user_shopping['User_id'];
            $Shopping_item[$i] = $row_user_shopping['Shoping_items'];
            $Shopping_cost[$i] = $row_user_shopping['Shopping_cost'];
            $Shopping_date[$i] = $row_user_shopping['Shopping_date'];
            $i++;
        }

        //Get Item Quantity
        for ($m = 0; $m < $i; $m++) {
            $cnt = split("\,", $Shopping_item[$m]);
            $Shopping_quantity[$m] = count($cnt) - 1;
        }

        echo "
				<div id='profile_page'>
					<div id='AdminGroupBtn'><div class='btn-group'>
					  <a href='MyAcc.php'><button name='Profile' type='button' class='btn btn-primary'>Profile</button></a>
					  <a href='MyAcc.php?AdminEdit=$user_User'><button name='Edit' type='button' class='btn btn-primary'>Edit</button></a>
					  <a href='MyAcc.php?viewUser=$user_User'><button name='ViewUser' type='button' class='btn btn-primary'>View Customer</button></a>
					  <a href='MyAcc.php?userShopInfo=$user_User'><button name='Shoppinginfo' type='button' class='btn btn-primary'>View Order</button></a>
					  <a href='AddProduct.php'><button name='AddProduct' type='button' class='btn btn-primary'>Product</button></a>
					  
					  <a href='MyAcc.php?adminID=$user_User'><button name='Logout' type='button' class='btn btn-primary'>Log Out</button></a></a>
					</div></div>
				

				<div id='shoppinginfo'>
					<table id='User'>
						<tr id='title'>
						    <th colspan='7'>User Shopping Information</th>
						</tr>
						<tr id='title'>
							<td>No</td>
						    <td>Items</td>
						    <td>Quantity</td>
						    <td>Cost&nbsp;</td>
						    <td>Customer</td>
						    <td>Date</td>
						    <td> - </td>
						</tr>
					</table>
				</div>
			";

        for ($n = 0; $n < $i; $n++) {

            echo "

					<div id='shoppinginfoPrevious'>
						<table id='UserPrevious'>
							<tr class='alt'>
						    	<td>$j</td>
						    	<td>&nbsp;$Shopping_item[$n]&nbsp;</td>
						    	<td>$Shopping_quantity[$n]</td>
						    	<td>$Shopping_cost[$n]</td>
						    	<td style='margin-top:5px;' height='50px;'><a href='MyAcc.php?CusProId=$Customer_id[$n]'><button  name='Button' class='btn btn-primary btn-xs'>View</button></td>
						    	<td>$Shopping_date[$n]</td>
						    	<td style='margin-top:5px;' height='50px;'><a href='index.php'><button  name='Button' class='btn btn-primary btn-xs'>X</button></td>
						  	</tr>
						</table>
					</div>
					

					";
            $j++;
        }
        $j = 0;
    }
}

function Category() {
    
}

function Brand() {
    
}

function AdminLogOut() {
    if (isset($_GET['adminID'])) {

        unset($_SESSION['sess_UserId']);
        unset($_SESSION['sess_Username']);
        unset($_SESSION['sess_Password']);
        unset($_SESSION['loggedin']);
        unset($_SESSION['key']);
        session_destroy();

        echo "
				<script>window.open('MyAcc.php','_self')</script>

			";
    }
}

/////////////////////////////////END Admin control//////////////////////////////////////////////
//User profile page ----------------------------------------------------------------------------------
function User_profile() {
    if (!isset($_GET['userId']) && !isset($_GET['userEdit']) && !isset($_GET['userShopInfo']) && !isset($_POST['EditSubmit'])) {
        $username = $_SESSION['sess_Username'];


        global $con;

        $get_user_pro = "select * from userinfo where Username='$username'";

        $run_user_pro = mysqli_query($con, $get_user_pro);

        while ($row_user_pro = mysqli_fetch_array($run_user_pro)) {

            $user_Name = $row_user_pro['Fullname'];
            $user_User = $row_user_pro['Username'];
            $user_Pass = $row_user_pro['Password'];
            $user_Phone = $row_user_pro['Phone'];
            $user_Email = $row_user_pro['Email'];
            $user_Address = $row_user_pro['Address'];
            $user_image = $row_user_pro['User_image'];
        }

        echo "
				<div id='profile_page'>
					<div id='groupBtn'><div class='btn-group'>
					  <a href='MyAcc.php'><button name='Profile' type='button' class='btn btn-primary'>Profile</button></a>
					  <a href='MyAcc.php?userEdit=$user_User'><button name='Edit' type='button' class='btn btn-primary'>Edit</button></a>
					  <a href='MyAcc.php?userShopInfo=$user_User'><button name='Shoppinginfo' type='button' class='btn btn-primary'>Shopping Info</button></a>
					  <a href='MyAcc.php?userId=$user_User'><button name='Logout' type='button' class='btn btn-primary'>Log Out</button></a></a>
					</div></div>

					<h4 id='name'>User Logged In</h4>
					<h4 id='name'>Welcome, $user_Name</h4>
					
					<div id='profile_pic'>
						<img src='user_img//$user_image' class='img-circle' alt='Cinque Terre' width='160' height='157'>
					</div>
					
					<div id='infotable'>
						<table id='customers'>
							<tr >
						    	<th colspan='2'>User Information</th>
						  	</tr>
						  <tr class='alt'>
						    <td><div style='float:right;'>Name</div></td>
						    <td><div style='float:left;'>$user_Name</div></td>
						  </tr>
						  <tr>
						    <td><div style='float:right;'>Username</div></td>
						    <td><div style='float:left;'>$user_User</div></td>
						  </tr>
						  <tr class='alt'>
						    <td><div style='float:right;'>Password</div></td>
						    <td><div style='float:left;'>$user_Pass</div></td>
						  </tr>
						  <tr>
						    <td><div style='float:right;'>Phone</div></td>
						    <td><div style='float:left;'>$user_Phone</div></td>
						  </tr>
						  <tr class='alt'>
						    <td><div style='float:right;'>Email</div></td>
						    <td><div style='float:left;'>$user_Email</div></td>
						  </tr>
						  <tr>
						    <td><div style='float:right;'>Address</div></td>
						    <td><div style='float:left;'>$user_Address</div></td>
						  </tr>
						</table>

					</div>

					
				</div>
			";
    }
}

function ShoppingInfo() {
    if (isset($_GET['userShopInfo'])) {

        $username = $_SESSION['sess_Username'];
        global $con;
        $Shopping_arr1 = array(50);
        $Shopping_arr2 = array(50);
        $Shopping_arr3 = array(50);
        $i = 0;
        $j = 1;

        $get_user_pro = "select * from userinfo where Username='$username'";

        $run_user_pro = mysqli_query($con, $get_user_pro);

        while ($row_user_pro = mysqli_fetch_array($run_user_pro)) {

            $user_id = $row_user_pro['User_id'];
            $user_User = $row_user_pro['Username'];
        }

        $get_user_shopping = "select * from user_shopping_info where User_id='$user_id'";

        $run_user_shopping = mysqli_query($con, $get_user_shopping);

        while ($row_user_shopping = mysqli_fetch_array($run_user_shopping)) {

            $Shopping_arr1[$i] = $row_user_shopping['Shoping_items'];
            $Shopping_arr2[$i] = $row_user_shopping['Shopping_cost'];
            $Shopping_arr3[$i] = $row_user_shopping['Shopping_date'];
            $i++;
        }

        echo "
				<div id='profile_page'>
					<div id='groupBtn'><div class='btn-group'>
					  <a href='MyAcc.php'><button name='Profile' type='button' class='btn btn-primary'>Profile</button></a>
					  <a href='MyAcc.php?userEdit=$user_User'><button name='Edit' type='button' class='btn btn-primary'>Edit</button></a>
					  <a href='MyAcc.php?userShopInfo=$user_User'><button name='Shoppinginfo' type='button' class='btn btn-primary'>Shopping Info</button></a>
					  <a href='MyAcc.php?userId=$user_id'><button name='Logout' type='button' class='btn btn-primary'>Log Out</button></a></a>
					</div></div>
				

				<div id='shoppinginfo'>
					<table id='User'>
						<tr id='title'>
						    <th colspan='4'>User Shopping Information</th>
						</tr>
						<tr id='title'>
							<td>No</td>
						    <td>&nbsp;&nbsp;&nbsp;Items&nbsp;&nbsp;</td>
						    <td>Cost</td>
						    <td>Date</td>
						</tr>
					</table>
				</div>
			";

        for ($n = 0; $n < $i; $n++) {
            echo "

					<div id='shoppinginfoPrevious'>
						<table id='UserPrevious'>
							<tr class='alt'>
						    	<td wight='100px;'>$j</td>
						    	<td>$Shopping_arr1[$n]</td>
						    	<td>$Shopping_arr2[$n]</td>
						    	<td>$Shopping_arr3[$n]</td>
						  	</tr>
						</table>
					</div>
					";
            $j++;
        }
        $j = 1;
    }
}

function Edit() {
    if (isset($_GET['userEdit'])) {

        $username = $_SESSION['sess_Username'];
        global $con;

        $get_user_pro = "select * from userinfo where Username='$username'";

        $run_user_pro = mysqli_query($con, $get_user_pro);

        while ($row_user_pro = mysqli_fetch_array($run_user_pro)) {

            $user_id = $row_user_pro['User_id'];
            $user_Name = $row_user_pro['Fullname'];
            $user_User = $row_user_pro['Username'];
            $user_Pass = $row_user_pro['Password'];
            $user_Phone = $row_user_pro['Phone'];
            $user_Email = $row_user_pro['Email'];
            $user_Address = $row_user_pro['Address'];
            $user_image = $row_user_pro['User_image'];
        }

        echo "
				<div id='profile_page'>
					<div id='groupBtn'><div  class='btn-group'>
					  <a href='MyAcc.php'><button name='Profile' type='button' class='btn btn-primary'>Profile</button></a>
					  <a href='MyAcc.php?userEdit=$user_User'><button name='Edit' type='button' class='btn btn-primary'>Edit</button></a>
					  <a href='MyAcc.php?userShopInfo=$user_User'><button name='Shoppinginfo' type='button' class='btn btn-primary'>Shopping Info</button></a>
					  <a href='MyAcc.php?userId=$user_id'><button name='Logout' type='button' class='btn btn-primary'>Log Out</button></a></a>
					</div></div>
					
					<form action='MyAcc.php' method='post' >
						<div id='infotable'>
							<table id='customers'>
								<tr >
							    	<th colspan='2'>User Edit Information</th>
							  	</tr>
							  <tr class='alt'>
							    <td>Name</td>
							    <td><div style='vertical-alignment:center'><input name='Name' type='text' size='45' value='$user_Name'></div></td>
							  </tr>
							  <tr>
							    <td>Username</td>
							    <td><div style='vertical-alignment:center'><input name='Username' type='text' size='45' value='$user_User'></div></td>
							  </tr>
							  <tr class='alt'>
							    <td>Password</td>
							    <td><div style='vertical-alignment:center'><input name='Password' type='text' size='45' value='$user_Pass'></div></td>
							  </tr>
							  <tr>
							    <td>Phone</td>
							    <td><div style='vertical-alignment:center'><input name='Phone' type='text' size='45' value='$user_Phone'></div></td>
							  </tr>
							  <tr class='alt'>
							    <td>Email</td>
							    <td><div style='vertical-alignment:center'><input name='Email' type='text' size='45' value='$user_Email'></div></td>
							  </tr>
							  <tr>
							    <td>Address</td>
							    <td><div style='vertical-alignment:center'><textarea name='Address' rows='4' cols='45'>$user_Address</textarea></div></td>
							  </tr>
							</table>
								<button type='submit' name='SubmitEdit' class='btn btn-primary' id='ProfileEditSubmit'>Submit Edit</button>

						</div>
					</form>

				</div>
			";
    }
}

function SubmitEdit() {

    if (isset($_POST['SubmitEdit'])) {

        $username = $_SESSION['sess_Username'];

        $Edit_Name = $_POST['Name'];
        $Edit_Username = $_POST['Username'];
        $Edit_Password = $_POST['Password'];
        $Edit_Phone = $_POST['Phone'];
        $Edit_Email = $_POST['Email'];
        $Edit_Address = $_POST['Address'];

        global $con;

        $edit_user_pro = "UPDATE userinfo
			SET Fullname='$Edit_Name', Username='$Edit_Username', Password='$Edit_Password', Phone='$Edit_Phone', Email='$Edit_Email', Address='$Edit_Address'
			WHERE Username='$username'
			";

        $run_edit_user_pro = mysqli_query($con, $edit_user_pro);

        if ($run_edit_user_pro) {
            echo "<script>alert('Your Profile Edit Successfully!');</script>";
            echo "<script>window.open('MyAcc.php','_self')</script>";
        } else {

            echo "<script>alert('Error occured!');</script>";
            echo "<script>window.open('MyAcc.php','_self')</script>";
        }
    }
}

function LogOut() {
    if (isset($_GET['userId'])) {

        unset($_SESSION['sess_UserId']);
        unset($_SESSION['sess_Username']);
        unset($_SESSION['sess_Password']);
        unset($_SESSION['loggedin']);
        session_destroy();

        echo "
				<script>window.open('MyAcc.php','_self')</script>

			";
    }
}

?>