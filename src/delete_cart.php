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
	$user = $_SESSION['user_login'];
	$result = mysqli_query($con, "SELECT * FROM user WHERE id='$user'");
	$user = mysqli_fetch_assoc($result);
	$uname_db = $user['firstName'];
	$uemail_db = $user['email'];

	$umob_db = $user['mobile'];
	$uadd_db = $user['address'];
}


if (isset($_REQUEST['cid'])) {
		$cid = mysqli_real_escape_string($con, $_REQUEST['cid']);
		if(mysqli_query($con, "DELETE FROM cart WHERE pid='$cid' AND uid='$user'")){
		header('location: cart.php?uid='.$user.'');
	}else{
		header('location: index.php');
	}
}
if (isset($_REQUEST['aid'])) {
		$aid = mysqli_real_escape_string($con, $_REQUEST['aid']);
		$result = mysqli_query($con, "SELECT * FROM cart WHERE pid='$aid'");
		$get_p = mysqli_fetch_assoc($result);
		$num = $get_p['quantity'];
		$num += 1;

		if(mysqli_query($con, "UPDATE cart SET quantity='$num' WHERE pid='$aid' AND uid='$user'")){
		header('location: cart.php?uid='.$user.'');
	}else{
		header('location: index.php');
	}
}
if (isset($_REQUEST['sid'])) {
		$sid = mysqli_real_escape_string($con, $_REQUEST['sid']);
		$result = mysqli_query($con, "SELECT * FROM cart WHERE pid='$sid'");
		$get_p = mysqli_fetch_assoc($result);
		$num = $get_p['quantity'];
		$num -= 1;
		if ($num <= 0){
			$num = 1;
		}
		if(mysqli_query($con, "UPDATE cart SET quantity='$num' WHERE pid='$sid' AND uid='$user'")){
		header('location: mycart.php?uid='.$user.'');
	}else{
		header('location: index.php');
	}
}


?>