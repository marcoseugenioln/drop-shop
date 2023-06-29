<?php include ( "inc/connect.inc.php" ); ?>
<?php 

ob_start();
session_start();

if (!isset($_SESSION['user_id'])) 
{
	header("location: login.php");
}
else 
{
	$user_id = $_SESSION['user_id'];
	$user = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM users WHERE user_id='$user_id'"));

	$user_first_name = $user['first_name'];
	$user_email = $user['email'];
	$user_mobile = $user['mobile'];
	$user_address = $user['address'];
}

if (isset($_REQUEST['user_id'])) {
	
	$requested_user_id = mysqli_real_escape_string($con, $_REQUEST['user_id']);
	
	if($user_id != $requested_user_id)
	{
		header('location: index.php');
	}
}
else 
{
	header('location: index.php');
}

$search_value = "";
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
						if ($user_id != "") 
						{
							echo '<a style="text-decoration: none; color: #fff;" href="logout.php">LOG OUT</a>';
						}
						else 
						{
							echo '<a style="text-decoration: none; color: #fff;" href="signin.php">SIGN IN</a>';
						}
					 ?>
					
				</div>
				<div class="uiloginbutton signinButton loginButton" style="">
					<?php 
						if ($user_id!="") 
						{
							echo '<a style="text-decoration: none; color: #fff;" href="profile.php?user_id='.$user_id.'">Hi '.$user_first_name.'</a>';
						}
						else 
						{
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
			<div id="srcheader">
				<form id="newsearch" method="get" action="search.php">
				        <?php 
				        	echo '<input type="text" class="srctextinput" name="keywords" size="21" maxlength="120"  placeholder="Search Here..." value="'.$search_value.'"><input type="submit" value="search" class="srcbutton" >';
				         ?>
				</form>
			<div class="srcclear"></div>
			</div>
		</div>
		<div class="categolis">
			<table>
				<tr>
					<th><?php echo '<a href="mycart.php?user_id='.$user_id.'" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #fff;border-radius: 12px;">My Cart</a>'; ?></th>
					<th>
						<?php echo '<a href="profile.php?user_id='.$user_id.'" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">My Orders</a>'; ?>
					</th>
					<th>
						<?php echo '<a href="my_delivery.php?user_id='.$user_id.'" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #fff;border-radius: 12px;">MyDeliveryHistory</a>'; ?>
					</th>
					<th><?php echo '<a href="settings.php?user_id='.$user_id.'" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #fff;border-radius: 12px;">Settings</a>'; ?></th>
					

				</tr>
			</table>
		</div>
	<div style="margin-top: 20px;">
		<div style="width: 900px; margin: 0 auto;">
		
			<ul>
				
				<li style=" background-color: #fff;">
					<div>
						<div>
							<table class="rightsidemenu">
								<tr style="font-weight: bold;" colspan="10" bgcolor="#3A5487">
									<th>Product Name</th>
									<th>Price</th>
									<th>Total Product</th>
									<th>Order Date</th>
									<th>Delevery Date</th>
									<th>Delevery Place</th>
									<th>Delevery Status</th>
									<th>View</th>
								</tr>
								<tr>
									<?php 
										while ($row=mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM orders WHERE user_id='$user' ORDER BY id DESC"))) 
										{
											$product_id = $row['product_id'];
											$quantity = $row['quantity'];
											$order_place = $row['order_place'];
											$mobile = $row['mobile'];
											$order_date = $row['order_date'];
											$delivery_date = $row['delivery_date'];
											$delivery_status = $row['delivery_status'];
											
											//get product info
											$product = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM products WHERE product_id='$product_id'"));
											
											$product_name = substr($product['product_name'], 0,50);
											$price = $product['price'];
											$picture = $product['picture'];
											$item = $product['item'];
											$category = $product['category'];

											echo '<th>'.$product_name.'</th>';
											echo '<th>'.$price.'</th>';
											echo '<th>'.$quantity.'</th>';
											echo '<th>'.$order_date.'</th>';
											echo '<th>'.$delivery_date.'</th>';
											echo '<th>'.$order_place.'</th>';
											echo '<th>'.$delivery_status.'</th>';

											echo 
											'<th><div class="home-prodlist-img">
												<a href="OurProducts/view_product.php?product_id='.$product_id.'">
													<img src="image/product/'.$item.'/'.$picture.'" class="home-prodlist-imgi" style="height: 75px; width: 75px;">
												</a>
											</div></th>';
										}
									 ?>
								</tr>
							</table>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
</body>
</html>