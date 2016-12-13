<!DOCTYPE html>
<?php
	include("functions/functions.php");
?>
<html>
	<head>
		<title>Registration</title>
<!--		<link rel="icon" href="images/favicon.PNG" type="image/x-icon"/>-->
		<link rel="stylesheet" type="text/css" href="styles/style.css">
		<link href="styles/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		

		<!--Bootstrap-->
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  		
	</head>
<body id="regBody">
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
				<li><a href="MyAcc.php">My Account</a></li>
				<li><a style="background-color: #FF0066;border-radius: 10px;color:white;" href="signup.php">Sign Up</a></li>
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
					<input name="us" type="search" class="form-control" id="usrs" placeholder="Search Text Here" required>
					<input id="srcBtn" class="btn btn-info" type="submit" name="sub" value="Search"/>
				</form>
			</div>

		</div>
		<!--Navigation end-->
		
		<!--Main wrapper content start-->
		<div class="content_wrapper">
			
			<div id="content_area">
				<div id="Reg">
					<form action="signup.php" method="post" enctype="multipart/form-data">
						<h4 id="font" style="text-align:center">Registration</h4>
						<div id="con">
							<input size="10px" type="text" name="Fullname" class="form-control" id="me1" placeholder="Full Name" required>
							<input size="10px" type="text" name="Username" class="form-control" id="me2" placeholder="Username" required>
							<input size="10px" type="password" name="Password" class="form-control" id="me3" placeholder="Password" required>
							<input size="10px" type="text" name="Phone" class="form-control" id="me4" placeholder="Phone" required>
							<input size="10px" type="text" name="Email" class="form-control" id="me5" placeholder="Email" required>
							<textarea class="form-control" name="Address" rows="5" id="me6" placeholder="Address" required></textarea>
    						        <input type="file" name="user_image" id="me7" required/>
							<button type="submit" name="User_registration" id="but" class="btn btn-primary btn-lg btn-block">Sign Up</button>
						</div>
						
					</form>
				</div>
				
				

			</div>

		</div>
		<!--Main wrapper content end-->
		
		<div class="footer">
			<h4 style="text-align:center;padding-top:25px;">Online Shop 2016</h4>
		</div>
	</div>
	<!--Main content end-->

</body>
</html>
<?php
	$User_ip=getIp();
	if(isset($_POST['User_registration'])){
		$message="Registration Successfully !!!";

		//getting the user info data from the field
		$User_fullname=$_POST['Fullname'];
		$User_username=$_POST['Username'];
		$User_password=$_POST['Password'];
		$User_phone=$_POST['Phone'];
		$User_email=$_POST['Email'];
		$User_address=$_POST['Address'];

		//getting the image from the field
		$User_images=$_FILES['user_image']['name'];
		$User_images_tmp=$_FILES['user_image']['tmp_name'];

		move_uploaded_file($User_images_tmp, "user_img/$User_images");

		$check_Existence="select * from userinfo where Username='$User_username'";
		$check_exe=mysqli_query($con,$check_Existence);

		$check_user=mysqli_num_rows($check_exe);

		if($check_user!=0){
			echo "<script>
					alert('This username already exsit!');
				</script>";
			

			exit();
		}else{
			
			$insert_user_Info="insert into userinfo (Fullname,Username,Password,Phone,Email,Address,User_image,User_ip) values 
			('$User_fullname','$User_username','$User_password','$User_phone','$User_email','$User_address','$User_images','$User_ip')";

			$insert_uer=mysqli_query($con,$insert_user_Info);

			if ($insert_uer) {
				echo "
					<div id='succAlert' class='alert alert-success fade in'>
				    	<a  href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				    	<p><strong>Thanks $User_fullname,</strong>  Your Registration Successfull!</p>
				  	</div>

				";
			}

		}		


		


	}

?>