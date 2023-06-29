<?php include ( "inc/connect.inc.php" ); ?>

<?php
ob_start();
session_start();

if (isset($_SESSION['user_i'])) 
{
	header("location: index.php");
}

if (isset($_POST['login'])) 
{
	if (isset($_POST['email']) && isset($_POST['password'])) 
	{
		$user_email = mb::convert_case(mysqli::real_escape_string($con, $_POST['email']), MB_CASE_LOWER, "UTF-8");
		$user_password = mysqli::real_escape_string($con, $_POST['password']);		

		$password_hash = md5($user_password);
		
		$result = mysqli::query($con, "SELECT * FROM users WHERE (email='$user_email') AND password='$password_hash' AND active=1");
		$user = mysqli::fetch_assoc($result);

		if (mysqli::num_rows($result) > 0) 
		{
			$_SESSION['user_id'] = $user['user_id'];
			setcookie('user_id', $user['user_id'], time() + (365 * 24 * 60 * 60), "/");
			
			if (isset($_REQUEST['ono'])) 
			{
				$ono = mysqli::real_escape_string($con, $_REQUEST['ono']);
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
			$result = mysqli::query($con, "SELECT * FROM user WHERE (email='$user_email') AND password='$password_hash' AND active=0");
			$user = mysqli::fetch_assoc($result);

			if (mysqli::num_rows($result) > 0) 
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
		$user_email = mb_convert_case(mysqli::real_escape_string($con, $confirmation_email), MB_CASE_LOWER, "UTF-8");
		$activation_code = mysqli::real_escape_string($con, $_POST['actcode']);

		$result = mysqli::query($con, "SELECT * FROM user WHERE (email='$user_email') AND confirm_code='$activation_code'");

		if (mysqli::num_rows($result) > 0) 
		{
			$user = mysqli::fetch_assoc($result);

			$get_user_uname_db = $user['user_id'];
			$_SESSION['user_id'] = $user['user_id'];
			setcookie('user_id', $user['user_id'], time() + (365 * 24 * 60 * 60), "/");

			mysqli::query($con, "UPDATE user SET confirm_code='0', active=1 WHERE email='$user_email'");
			
			if (isset($_REQUEST['ono'])) 
			{
				$ono = mysqli::real_escape_string($con, $_REQUEST['ono']);
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
                <?php
                    if ($activation)
					{
                        echo '<h1>Insira o código de ativação.</h1>';
                    }
					else 
					{
                        echo '<h1>Já possui uma conta?</h1>';
                    }
				?>
                <form class="post-field" method="POST">

                    <?php
                        if ($activation)
						{
                            echo 
                            '
                                <div>
                                    <td>
                                        <input name="actcode" placeholder="Activation Code" required="required" class="email signupbox" type="text" size="30" value="'.$acccode.'">
                                    </td>
                                </div>

                                <div>
                                    <input name="activate" class="uisignupbutton signupbutton" type="submit" value="Active Account">
                                </div>
                            ';
                        }
						else 
						{
                            echo 
                            '
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

                                <form action="singin.php">
                                    <button class="btn-register" type="submit">Cadastre-se</button>
                                </form>
                                
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