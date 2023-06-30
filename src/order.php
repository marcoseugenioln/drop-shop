<?php include ( "inc/connect.inc.php" ); ?>
<?php 

if (isset($_REQUEST['poid'])) {
	
	$poid = mysqli_real_escape_string($con, $_REQUEST['poid']);
}else {
	header('location: index.php');
}
ob_start();
session_start();
if (isset($_SESSION['user_login'])) 
{
	$user_id = $_SESSION['user_id'];
	$user = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM users WHERE user_id='$user_id'"));

	$user_first_name = $user['first_name'];
	$user_last_name = $user['last_name'];
	$user_email = $user['email'];
	$user_mobile = $user['mobile'];
	$user_address = $user['address'];
}
else 
{
	$user_id = "";
	header("location: login.php?ono=".$poid."");
}


$getposts = mysqli_query($con, "SELECT * FROM products WHERE product_id ='$poid'") or die(mysqlI_error($con));

if (mysqli_num_rows($getposts)) 
{
	$row = mysqli_fetch_assoc($getposts);
	$id = $row['product_id'];
	$pName = $row['product_name'];
	$price = $row['price'];
	$description = $row['description'];
	$picture = $row['picture'];
	$item = $row['item'];
	$category = $row['category'];
	$available =$row['available'];
}	

//order

if (isset($_POST['order'])) 
{
	//declere veriable
	$mbl = $_POST['mobile'];
	$addr = $_POST['address'];
	$quan = $_POST['Quantity'];
	$del = $_POST['Delivery'];
	
	//triming name
	try {
		if(empty($_POST['mobile'])) {
			throw new Exception('Mobile can not be empty');
			
		}
		if(empty($_POST['address'])) {
			throw new Exception('Address can not be empty');
			
		}
		if(empty($_POST['Quantity'])) {
			throw new Exception('Quantity can not be empty');
			
		}
		if(empty($_POST['Delivery'])) {
			throw new Exception('Type of Delivery can not be empty');
			
		}

		
		// Check if email already exists
		
		
						$d = date("Y-m-d"); //Year - Month - Day
						
						// send email
						$msg = "
					
						Your Order suc

						
						";
						//if (@mail($user_email,"eBuyBD Product Order",$msg, "From:eBuyBD <no-reply@ebuybd.xyz>")) {
							
						if(mysqli_query($con, "INSERT INTO orders (uid,pid,quantity,oplace,mobile,odate,delivery) VALUES ('$user','$poid',$quan,'$_POST[address]','$_POST[mobile]','$d','$del')")){

							//success message
							

							
						$success_message = '
						<div class="signupform_content">
						<h2><font face="bookman"></font></h2>
						<script>
						alert("We will call you for confirmation very soon");
						</script>
						<div class="signupform_text" style="font-size: 18px; text-align: center;">
						<font face="bookman">

						</font></div></div>
						';
						

						

							
						}
						//}

	}
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Noodles&Canned</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="background-image: url(image/homebackgrndimg1.jpg);">
	<div class="homepageheader">
			<div class="signinButton loginButton">
				<div class="uiloginbutton signinButton loginButton" style="margin-right: 40px;">
					<?php 
						if ($user!="") {
							echo '<a style="text-decoration: none; color: #fff;" href="logout.php">LOG OUT</a>';
						}
						else {
							echo '<a style="text-decoration: none; color: #fff;" href="signin.php">SIGN IN</a>';
						}
					 ?>
					
				</div>
				<div class="uiloginbutton signinButton loginButton" style="">
					<?php 
						if ($user!="") {
							echo '<a style="text-decoration: none; color: #fff;" href="profile.php?uid='.$user.'">Hi '.$user_first_name.'</a>';
						}
						else {
							echo '<a style="text-decoration: none; color: #fff;" href="login.php">LOG IN</a>';
						}
					 ?>
				</div>
			</div>
			<div style="float: left; margin: 5px 0px 0px 23px;">
				<a href="index.php">
					<img style=" height: 75px; width: 130px;" src="image/cart.png">
				</a>
			</div>
			<div class="">
				<div id="srcheader">
					<form id="newsearch" method="get" action="search.php">
					        <input type="text" class="srctextinput" name="keywords" size="21" maxlength="120"  placeholder="Search Here..."><input type="submit" value="search" class="srcbutton" >
					</form>
				<div class="srcclear"></div>
				</div>
			</div>
		</div>
	<div class="categolis">
		<table>
			<tr>
				<th>
					<a href="OurProducts/NoodlesCanned.php" style="text-decoration: none;color:#040403 ;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Noodles&Canned</a>
				</th>
				<th><a href="OurProducts/Seasonings.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Seasonings</a></th>
				<th><a href="OurProducts/Drinks.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Drinks</a></th>
				<th><a href="OurProducts/Snacks.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Snacks</a></th>
				<th><a href="OurProducts/Sweets.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Sweets</a></th>
				<th><a href="OurProducts/Soap&Detergent.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Soap&Detergent</a></th>
				<th><a href="OurProducts/Shampoo.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Shampoo</a></th>
				<th><a href="OurProducts/Hygene.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Hygiene</a></th>
			</tr>
		</table>
	</div>
	<div class="holecontainer" style="padding: 20px 15%">
		<div class="container signupform_content ">
			<div>


				<div style="float: right;">

				<?php 
					if(isset($success_message)) {echo $success_message;

									echo '<h3 style="color:#169E8F;font-size:45px;"> Payment&Delivery </h3>';


						$user = $_SESSION['user_login'];
	$result = mysqli_query($con, "SELECT * FROM user WHERE id='$user'");
		$user = mysqli_fetch_assoc($result);
			$user_first_name = $user['first_name'];
			$user_last_name=$user['last_name'];
			$user_email = $user['email'];
			$user_mobile = $user['mobile'];
			$user_address = $user['address'];
			echo '<h3 style="color:black;font-size:25px;"> First Name: </h3>';
			echo'<span style="color:#34ce6c;font-size:25px;">'. $user_first_name.'</span>';
			echo '<h3 style="color:black;font-size:25px;"> Last Name: </h3>';
			echo'<span style="color:#34ce6c;font-size:25px;">' .$user_last_name.'</span>';
			echo '<h3 style="color:black;font-size:25px;"> Email: </h3>'; 
			echo '<span style="color:#34ce6c;font-size:25px;">' .$user_email.'</span>';
			echo '<h3 style="color:black;font-size:25px;"> Contact Number: </h3>';
			echo '<span style="color:#34ce6c;font-size:25px;">' .$user_mobile.'</span>';
			echo '<h3 style="color:black;font-size:25px;"> Home Address: </h3>';
			echo '<span style="color:#34ce6c;font-size:25px;">'.$user_address.'</span>';
			
			$del = $_POST['Delivery'] ;
			echo '<h3 style="color:black;font-size:25px;">Types of Delivery:</h3>';
			echo'<span style="color:#34ce6c;font-size:25px;">' .$del.'</span>';
			$quan = $_POST['Quantity'];
			echo '<h3 style="color:black;font-size:25px;"> Quantity: </h3>';
			echo'<span style="color:#34ce6c;font-size:25px;">' .$quan.'</span>';
			
			echo '<h3 style="color:#169E8F;font-size:45px;"> Total: Php '.$quan * $price.' Php</h2>';
			

	

			

					}
					else {
					echo '
						<div class="">
						<div class="signupform_text"></div>
						<div>
							<form action="" method="POST" class="registration">
								<div class="signup_form">
								<h3 style="color:red;font-size:18px; padding: 5px;">Accepting CashOnDelivery Only</h3>
									<div>
										<td>
											<input name="fullname" placeholder="your name" required="required" class="email signupbox" type="text" size="30" value="'.$user_first_name.'">
										</td>
									</div>

									<div>
										<td>
											<input name="last_name" placeholder="Your last name" required="required" class="email signupbox" type="text" size="30" value="'.$user_last_name.'">
										</td>
									</div>



									<div>
									<td>
											<input name="mobile" placeholder="Your mobile number" required="required" class="email signupbox" type="text" size="30" value="'.$user_mobile.'">
										</td>
									</div>
									<div>
										<td>
											<input name="address" id="password-1" required="required"  placeholder="Write your full address" class="password signupbox " type="text" size="30" value="'.$user_address.'">
										</td>
									</div>

									<div>
									<td>

									<font style="italic" family="arial" size="5px" color="#169e">
									Types of Delivery <br>
									

									 <input name="Delivery" required="required" value="Express Delivery +100php upon cash on delivery" type="radio"  placeholder="Mode Of Payment"> Express Delivery </br>
									 <input name="Delivery" type="radio" value="Standard Delivery" required="required" placeholder="Mode Of Payment"> Standard Delivery </br>
									 </font>


									</td>
									</div>


									<div>
									<td>

									 <input name="Quantity" required="required" type="number" min="1" class="password signupbox" placeholder="Quantity">

									</td>
									</div>
									


									



									
									<div>
										<input name="order" class="uisignupbutton signupbutton" type="submit" value="Confirm Order">
									</div>
									<div class="signup_error_msg"> '; ?>
										<?php 
											if (isset($error_message)) {echo $error_message;}
											
										?>
									<?php echo '</div>
								</div>
							</form>
							
						</div>
					</div>

					';

					}

				 ?>
					</h3>
				</div>

			</div>
		</div>
		<div style="float: left; font-size: 23px;">
			<div>
				<?php
					echo '
						<ul style="float: left;">
							<li style="float: left; padding: 0px 25px 25px 25px;">
								<div class="home-prodlist-img"><a href="'.$category.'/view_product.php?pid='.$id.'">
									<img src="image/product/'.$item.'/'.$picture.'" class="home-prodlist-imgi">
									</a>
									<div style="text-align: center; padding: 0 0 6px 0;"> <span style="font-size: 15px;">'.$pName.'</span><br> Price: '.$price.' Php</div>
								</div>
								
							</li>
						</ul>
					';
				?>
			</div>

		</div>
	</div>
</body>
</html>