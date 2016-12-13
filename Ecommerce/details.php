<!DOCTYPE html>
<?php
	include("functions/functions.php");
?>
<html>
	<head>
		<title>Details Product</title>
		<link rel="icon" href="images/favicon.PNG" type="image/x-icon"/>
		<link rel="stylesheet" type="text/css" href="styles/style.css">
		<link href="styles/bootstrap.min.css" rel="stylesheet" type="text/css"/>

		<!--Bootstrap-->
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

  		<!-- Magic zoom -->
        <link href="style/magiczoom.css" rel="stylesheet" type="text/css" media="screen"/>
        <script src="js/magiczoom.js" type="text/javascript"></script>
	</head>
<body>
	<!--Main content start-->
	<div class="main_wrapper">

		<!--Header start-->
		<div class="header_wrapper">
			<a href="index.php"><img id="logo"  src="images/logo.PNG" alt="logo"></a>
			<img id="banner" src="images/banners.PNG" alt="banner">

		</div>
		<!--Header end-->

		<!--Navigation start-->
		<div class="menubar">
			<ul id="menu">
				<li><a style="background-color: #FF0066;border-radius: 10px;color:white;" href="">Home</a></li>
				<li><a href="#">All Products</a></li>
				<li><a href="MyAcc.php">My Account</a></li>
				<li><a href="signup.php">Sign Up</a></li>
				<li><a href="">Shopping Cart</a></li>
				
			</ul>

			<!-- Modal -->
			  <div class="modal fade" id="myModal" role="dialog">
			    <div class="modal-dialog">
			      <!-- Modal content-->
			      <div id="modelcon" class="modal-content">
			        
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 class="modal-title">Your Cart</h4>
			        </div>

			        <div class="modal-body">
			        	<?php Shopping_Fun();?>
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
					<input type="search" name="us" type="text" class="form-control" id="usrs" placeholder="Search Text Here" required>
					<input id="srcBtn" class="btn btn-info" type="submit" name="sub" value="Search"/>
				</form>
			</div>

		</div>
		<!--Navigation end-->
		
		<!--Main wrapper content start-->
		<div class="content_wrapper">
			<div id="sidebar">
				<div id="sidebar_title">Categories</div>
				
				<ul id="cats">
					<?php getCats(); ?>
				</ul>

				<div id="sidebar_title">Brands</div>
				
				<ul id="cats">
					<?php getBrands(); ?>
				</ul>

			</div>
			<div id="content_area">
				<div id="product_box">
					<?php
						if(isset($_GET['pro_id'])){

							$product_id=$_GET['pro_id'];
							$get_pro="select * from products where product_id='$product_id'";

							$run_pro=mysqli_query($con, $get_pro);

							while ($row_pro=mysqli_fetch_array($run_pro)) {

								$pro_id=$row_pro['product_id'];
								$pro_title=$row_pro['product_title'];
								$pro_price=$row_pro['product_price'];
								$pro_image=$row_pro['product_image'];
								$pro_desc=$row_pro['product_desc'];

								echo "
									<div id='single_product'>
										<h4>$pro_title</h4>
				
										<a id='hk' href='admin_area/product_images/$pro_image' title='$pro_title' class='MagicZoom'><img class='img-thumbnail' id='hd' src='admin_area/product_images/$pro_image'/></a>
      							
										<p style='color:black;'>$pro_desc</p>
										<p><b>$pro_price</b></p>
										<a id='details' href='index.php' style='float:left;'>Go Back</a>
										<a href='index.php?add_card=$pro_id'><button class='btn btn-primary btn-md'  style='float:right;'>Add to Cart</button></a>

									</div>

								";
							}
						}
					?>
					
				</div>
				

			</div>

		</div>
		<!--Main wrapper content end-->
		
		<div class="footers">
			<h2 style="text-align:center;padding-top:25px;">&copy;copyright SHFN Online Shop 2015</h2>
		</div>
	</div>
	<!--Main content end-->

</body>
</html>