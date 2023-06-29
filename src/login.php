<?php include ( "inc/connect.inc.php" ); ?>

<?php
ob_start();
session_start();

if (isset($_SESSION['user_id'])) 
{
	header("location: index.php");
}

if (isset($_POST['login'])) 
{
	if (isset($_POST['email']) && isset($_POST['password'])) 
	{
		$user_email = mb_convert_case(mysqli_real_escape_string($con, $_POST['email']), MB_CASE_LOWER, "UTF-8");
		$user_password = mysqli_real_escape_string($con, $_POST['password']);		

		$password_hash = md5($user_password);
		
		$result = mysqli_query($con, "SELECT * FROM users WHERE (email='$user_email') AND password='$password_hash' AND is_active=1");
		$user = mysqli_fetch_assoc($result);

		if (mysqli_num_rows($result) > 0) 
		{
			$_SESSION['user_id'] = $user['user_id'];
			setcookie('user_id', $user['user_id'], time() + (365 * 24 * 60 * 60), "/");
			
			if (isset($_REQUEST['ono'])) 
			{
				$ono = mysqli_real_escape_string($con, $_REQUEST['ono']);
				header("location: order.php?poid=".$ono."");
			}
			else 
			{
				header('location: index.php');
			}

			exit();
		}
		else 
		{
			$result = mysqli_query($con, "SELECT * FROM users WHERE (email='$user_email') AND password='$password_hash' AND is_active=0");
			$user = mysqli_fetch_assoc($result);

			if (mysqli_num_rows($result) > 0) 
			{
				$confirmation_email = $user_email;
				$activation = true;
			}
			
			else 
			{
				$error_message = 
				'
					<br><br>
					<div class="maincontent_text" style="text-align: center; font-size: 18px;">
					<font face="bookman">Email or Password incorrect.<br>
					</font></div>
				';
			}
		}
	}
}

if(isset($_POST['activate']))
{
	if(isset($_POST['actcode']))
	{
		$user_email = mb_convert_case(mysqli_real_escape_string($con, $confirmation_email), MB_CASE_LOWER, "UTF-8");
		$activation_code = mysqli_real_escape_string($con, $_POST['actcode']);

		$result = mysqli_query($con, "SELECT * FROM user WHERE (email='$user_email') AND confirm_code='$activation_code'");

		if (mysqli_num_rows($result) > 0) 
		{
			$user = mysqli_fetch_assoc($result);

			$_SESSION['user_id'] = $user['user_id'];
			setcookie('user_id', $user['user_id'], time() + (365 * 24 * 60 * 60), "/");

			mysqli_query($con, "UPDATE user SET confirm_code='0', is_active=1 WHERE email='$user_email'");
			
			if (isset($_REQUEST['ono'])) 
			{
				$ono = mysqli_real_escape_string($con, $_REQUEST['ono']);
				header("location: order.php?poid=".$ono."");
			}
			else 
			{
				header('location: index.php');
			}
			exit();

		}
		else 
		{
			$error_message = 
			'
				<br><br>
				<div class="maincontent_text" style="text-align: center; font-size: 18px;">
				<font face="bookman">Code not matched!<br>
				</font></div>
			';
		}
	}
	
	else 
	{
		$error_message = 
		'
			<br><br>
			<div class="maincontent_text" style="text-align: center; font-size: 18px;">
			<font face="bookman">Activation code not matched!<br>
			</font></div>
		';
	}

}

?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="stylesheet/login.css">
    	<title>Login</title>
	</head>
	<body>
		<div class="main-login">
        <div class="left-login">
            <img src="images/logo.png" class="left-login-img" alt="logo">        
        </div>
        <div class="right-login">
            <div class="card-login">
                <form class="post-field" method="POST">

                    <?php
                        if (isset($activation))
						{
                            echo 
                            '
								<h1>Insira o código de ativação.</h1>
                                <div>
                                    <td>
                                        <input name="actcode" placeholder="Insira o código de ativação." required="required" class="email signupbox" type="text" size="30">
                                    </td>
                                </div>

                                <div>
                                    <input name="activate" class="uisignupbutton signupbutton" type="submit" value="Ativar">
                                </div>
                            ';
                        }
						else 
						{
                            echo 
                            '
								<h1>Já possui uma conta?</h1>
                                <div class="text-field">
                                    <label for="email">E-mail:</label>
                                    <input type="text" name="email" placeholder="E-mail">
                                </div>

                                <div class="text-field">
                                    <label for="senha">Senha:</label>
                                    <input type="password" name="password" placeholder="Senha">
                                </div>

                                <button name="login" class="btn-login" type="submit">Login</button><br>

                                <a role="button" class="forgotten-password" href="forgotten_password.php" rel="async">Esqueci a senha</a>                                
								<a style="text-decorations:none;" href="sign_in.php" rel="async" class="btn-register">Cadastre-se</a>
                            ';
                        }
				    ?>
                </form>

                <div class="signup_error_msg">
                    <?php 
                        if (isset($error_message)) {echo $error_message;} 
                    ?>
                </div>
                
            </div>
        </div>
    </div>
</html>
