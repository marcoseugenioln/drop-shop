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
	$result = mysqli_query($con, "SELECT * FROM users WHERE user_id='$user_id'");
	$user = mysqli_fetch_assoc($result);
	$user_first_name = $user['first_name'];
	$user_email = $user['email'];

	$user_mobile = $user['mobile'];
	$user_address = $user['address'];
}


if (isset($_REQUEST['cid'])) 
{
	$product_id = mysqli_real_escape_string($con, $_REQUEST['cid']);

	if(mysqli_query($con, "DELETE FROM cart WHERE pid='$product_id' AND user_id='$user_id'"))
	{
		header('location: cart.php?user_id='.$user_id.'');
	}
	else
	{
		header('location: index.php');
	}
}

if (isset($_REQUEST['aid'])) 
{
	$product_id = mysqli_real_escape_string($con, $_REQUEST['aid']);
	$cart_item = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM cart WHERE product_id='$product_id'"));
	$new_quantity = $cart_item['quantity'] + 1;

	if(mysqli_query($con, "UPDATE cart SET quantity='$new_quantity' WHERE product_id='$product_id' AND user_id='$user_id'"))
	{
		header('location: cart.php?user_id='.$user.'');
	}
	else
	{
		header('location: index.php');
	}
}

if (isset($_REQUEST['sid'])) 
{
	$product_id = mysqli_real_escape_string($con, $_REQUEST['sid']);
	$cart_item = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM cart WHERE product_id='$product_id'"));
	$new_quantity = $get_p['quantity'] - 1;

	if ($new_quantity <= 0)
	{
		$new_quantity = 1;
	}

	if(mysqli_query($con, "UPDATE cart SET quantity='$num' WHERE pid='$sid' AND user_id='$user_id'"))
	{
		header('location: mycart.php?user_id='.$user_id.'');
	}
	else
	{
		header('location: index.php');
	}
}

?>