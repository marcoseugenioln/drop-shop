<?php include ( "inc/connect.inc.php" ); ?>
<?php 
ob_start();
session_start();

if (isset($_SESSION['user_id'])) 
{
	$user_id = $_SESSION['user_id'];
	$user = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM users WHERE user_id='$user_id'"));
	$uname_db = $user != null ? $user['first_name'] : null;
}
else 
{
	$user_id = "";
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Welcome to Drop Shop</title>
		<link rel="stylesheet" type="text/css" href="stylesheet/index.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="scripts/slide_show.js"></script>
	</head>
	<body style="min-width: 980px;">
		<div class="homepageheader" style="position: relative;">
			<div class="signinButton loginButton">
				<div class="uiloginbutton signinButton loginButton" style="margin-right: 40px;">
					<?php 
						if ($user_id != "") 
						{
							echo '<a style="text-decoration: none; color: #fff;" href="logout.php">LOG OUT</a>';
						}
						else 
						{
							echo '<a style="color: #fff; text-decoration: none;" href="signin.php">SIGN UP</a>';
						}
					 ?>
					
				</div>
				<div class="uiloginbutton signinButton loginButton">
					<?php 
						if ($user_id!="") 
						{
							echo '<a style="text-decoration: none; color: #fff;" href="profile.php?uid='.$user_id.'">Hi '.$uname_db.'</a>';
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
			<div class="">
				<div id="srcheader">
					<form id="newsearch" method="get" action="search.php">
					        <input type="text" class="srctextinput" name="keywords" size="21" maxlength="120"  placeholder="Search Here..."><input type="submit" value="search" class="srcbutton" >
					</form>
				<div class="srcclear"></div>
				</div>
			</div>
		</div>

		<div class="home-welcome">
			<div class="home-welcome-text" style="background-image: url(images/background.jpg); height: 380px; ">
				<div style="padding-top: 180px;">
					<div style=" background-color: #dadbe6;">
						<h1 style="margin: 0px;">Welcome To nita's online grocery</h1>
						<h2>Most Convenient Store in 7th ave. Caloocan</h2>
					</div>
				</div>
			</div>
		</div>

		<div class="slideshow-container">
			
			<?php
				$run = mysqli_query($con, "SELECT * FROM banners ORDER BY banner_id DESC");

				while ($banners = mysqli_fetch_assoc($run)) 
				{ 
					echo 
					'
					<div class="mySlides fade">
						<div class="numbertext">'.$banners['banner_id'].'</div>
						<a href="'.$banners['redirect'].'" >
							<img src="'.$banners['image'].'" style="height: 75px; width: 130px;" alt="'.$banners['image'].'">
						</a>
					</div>
					';
				}
			?>

			<!-- Next and previous buttons -->
			<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
			<a class="next" onclick="plusSlides(1)">&#10095;</a>
		</div>
		<br>

		<!-- The dots/circles -->
		<div style="text-align:center">
			<?php
				$run = mysqli_query($con, "SELECT * FROM banners ORDER BY banner_id DESC");

				$count = 1;
				while ($banners = mysqli_fetch_assoc($run)) 
				{
					echo '<span class="dot" onclick="currentSlide('.$count.')"></span>';
					$count +=1;
				}
				
			?>
		</div>
	</body>
</html>