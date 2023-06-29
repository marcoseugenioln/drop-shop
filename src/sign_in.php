<?php include ( "inc/connect.inc.php" ); ?>

<?php

ob_start();
session_start();

if (isset($_SESSION['user_id'])) 
{
	header("location: index.php");
}

$user_first_name = "";
$user_last_name = "";
$user_email = "";
$user_mobile = "";
$user_address = "";
$user_pass = "";

if (isset($_POST['signup'])) 
{
	$user_first_name = trim($_POST['first_name']);
	$user_last_name = trim($_POST['last_name']);
	$user_email = $_POST['email'];
	$user_mobile = $_POST['mobile'];
	$user_address = $_POST['address'];
	$user_pass = $_POST['password'];


	try 
	{
		if(empty($_POST['first_name'])) 
		{
			throw new Exception('Fullname can not be empty');
		}
		if (is_numeric($_POST['first_name'][0])) 
		{
			throw new Exception('Please write your correct name!');
		}
		if(empty($_POST['last_name'])) 
		{
			throw new Exception('last_name can not be empty');
		}
		if (is_numeric($_POST['last_name'][0])) 
		{
			throw new Exception('last_name first character must be a letter!');
		}
		if(empty($_POST['email'])) 
		{
			throw new Exception('Email can not be empty');
		}
		if(empty($_POST['mobile'])) 
		{
			throw new Exception('Mobile can not be empty');
		}
		if(empty($_POST['password'])) 
		{
			throw new Exception('Password can not be empty');
		}
		if(empty($_POST['signupaddress'])) 
		{
			throw new Exception('Address can not be empty');
		}

		
		// Check if email already exists
		$is_email_available = mysqli_num_rows(mysqli_query($con, "SELECT email FROM `users` WHERE email='$user_email'")) == 0;
		$is_first_name_valid = (strlen($_POST['first_name']) > 2 && strlen($_POST['first_name']) < 20);
		$is_last_name_valid = (strlen($_POST['last_name']) > 2 && strlen($_POST['last_name']) < 20);
		$is_password_valid = (strlen($_POST['password']) > 1);

		if ($is_first_name_valid) 
		{
			if ($is_last_name_valid) 
			{
				if ($is_email_available) 
				{
					if ($is_password_valid) 
					{
						$d = date("Y-m-d"); //Year - Month - Day
						$_POST['first_name'] = ucwords($_POST['first_name']);
						$_POST['last_name'] = ucwords($_POST['last_name']);
						$_POST['email'] = mb_convert_case($user_email, MB_CASE_LOWER, "UTF-8");
						$_POST['password'] = md5($_POST['password']);

						$confirmation_code = substr( rand() * 900000 + 100000, 0, 6 );
						
						// send email
						$msg = "
						...
						
						Your activation code: ".$confirmation_code."
						Signup email: ".$_POST['email']."
						
						";							
						$result = mysqli_query($con, "INSERT INTO users (first_name,last_name,email,mobile,address,password,confirmation_code) VALUES ('$_POST[first_name]','$_POST[last_name]','$_POST[email]','$_POST[mobile]','$_POST[signupaddress]','$_POST[password]','$confirmation_code')");

						$success_message = 
						'
							<div class="signupform_content"><h2><font face="bookman">Registration successfull!</font></h2>
							<div class="signupform_text" style="font-size: 18px; text-align: center;">
							<font face="bookman">
								Email: '.$user_email.'<br>
								Activation code sent to your email. <br>
								Your activation code: '.$confirmation_code.'
							</font></div></div>
						';
					}
					else 
					{
						throw new Exception('Make strong password!');
					}
				}
				else 
				{
					throw new Exception('Email already taken!');
				}
			}
			else 
			{
				throw new Exception('last_name must be 2-20 characters!');
			}
		}
		
		else 
		{
			throw new Exception('first_name must be 2-20 characters!');
		}

	}
	catch(Exception $e) 
	{
		$error_message = $e->getMessage();
	}
}

?>


<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet/sign_in.css">
    <title>Sign In</title>
</head>
	<body>
		<?php 
			if(isset($success_message)) 
			{
				echo $success_message;
			}
			else 
			{
				echo '
				<div class="header">
				<strong>Por favor, preencha os campos abaixo:</strong>  
				</div>
				<div class="form-register">         
					<form class="personal-data" method="POST">
						<label for="nome-completo">Nome</label><br>
							<input type="text" name="nome-completo"><br>
						<label for="nome-completo">Sobrenome</label><br>
							<input type="text" name="nome-completo"><br>
						<label for="genero">Gênero*</label><br>
						<select class="gender" name="genero">
							<option value="sel">Selecione</option>
							<option value="fem">Feminino</option>
							<option value="masc">Masculino</option>
							<option value="outro">Outro</option>
							<option value="nao">Prefiro não informar</option>
						</select><br>
						<label for="data-de-nasc">Data de nascimento*</label><br>
							<input type="text" name="data-de-nasc" placeholder="00/00/0000"><br>
						<label for="email">E-mail*</label><br>
							<input type="text" name="email" placeholder="nome@exemplo.com"><br>
						<label for="cpf" name>CPF*</label><br>
							<input type="text" name="cpf" placeholder="000.000.000-00"><br>
						<label for="celular" name>Celular*</label><br>
							<input type="text" name="telefone" placeholder="(00)00000-0000"><br>
						<label for="usuario" name>Usuário*</label><br>
							<input type="text" name="usuario"><br>
						<label for="senha" name>Senha*</label><br>
							<input type="password" name="senha"><br>
						<label for="confirmar-senha" name>Confirme sua senha*</label><br>
							<input type="password" name="confirmar-senha"><br>
						<button class="btn-register">Cadastre-se</button><br>
					</form>
					<a role="button" class="login" href="login.php" rel="async">Já tenho uma conta</a>
				</div>';
														
				if (isset($error_message)) 
				{
					echo $error_message;
				}
			}
		 ?>
	</body>
</html>
