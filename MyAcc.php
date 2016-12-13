<!DOCTYPE html>
<?php
	include("functions/functions.php");
	session_start();
?>
<html>
	<head>
		<title>Account</title>
<!--		<link rel="icon" href="images/favicon.PNG" type="image/x-icon"/>-->
		<link rel="stylesheet" type="text/css" href="styles/style.css">
		<link rel="stylesheet" type="text/css" href="js/bootbox.min.js">
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
				<li><a style="background-color: #FF0066;border-radius: 10px;color:white;" href="">My Account</a></li>
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
			<?php
				if(isset($_SESSION['loggedin']))
				{
					$username=$_SESSION['sess_Username'];

					if (strcmp($username, "jamil")) {
						User_profile();
						Edit();
						ShoppingInfo();
						LogOut();
						SubmitEdit();
					}else{
						Admin_profile();
						AdminLogOut();
						ViewOrder();
						AdminEdit();
						AdminSubmitEdit();	
						ViewCustomer();
						CustomerProfile();
					}
				}else{
					echo "
						<div id='content_area'>
						<div id='Log'>
							<form action='MyAcc.php' method='post'>
								<h4 id='font' style='text-align:center'>Log In</h4>
								<div id='con'>
									<input name='Login_Username' size='10px' type='text' class='form-control' id='me' placeholder='&#128697; Username' required>
									<input name='Login_Password' size='10px' type='password' class='form-control' id='me' placeholder='&#128274; Password' required>
									<button name='User_Login' type='submit' id='but' class='btn btn-primary btn-lg btn-block'>Sign in</button>
								</div>
							</form>	
						</div>

					";

				}
			?>				
				

			</div>

		</div>
		<!--Main wrapper content end-->
		
		<div class="footer">
			<h4 style="text-align:center;padding-top:25px;">&copy; Online Shop 2016</h4>
		</div>
	</div>
	<!--Main content end-->

</body>
</html>
<?php
	if (isset($_POST['User_Login'])) {
		$a="true";
		$username=$_POST['Login_Username'];
		$password=$_POST['Login_Password'];

		$get_user_Info="select * from userinfo where Username='$username' AND 	Password='$password'";

		$User_info=mysqli_query($con,$get_user_Info);

		$count_user=mysqli_num_rows($User_info);

				if($count_user==0){
					echo "
						<script>alert('Username and Password do not match');</script>
					";
					exit();
				}else{

					while ($row_user_info=mysqli_fetch_array($User_info)) {
						$user_id=$row_user_info['User_id'];

					}
						$_SESSION['sess_UserId']=$user_id;
						$_SESSION['sess_Username']=$username;
						$_SESSION['sess_Password']=$password;
						$_SESSION['loggedin']="true";
						echo "<script>window.open('MyAcc.php','_self')</script>";


				}


	}
?>