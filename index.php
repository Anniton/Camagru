<?php
session_start();
include_once("navigation.php");
include_once("user_functions.php");
require 'config/setup.php';

if(!empty($_POST)){
	$errors = array();
	$fullname = htmlspecialchars($_POST['fullname']);
	$username = htmlspecialchars($_POST['username']);
	$email = htmlspecialchars($_POST['mail']);
	$passwd = $_POST['passwd'];

	if (empty($_POST['fullname']) || !preg_match('/^[a-zA-Z]+$/', $_POST['fullname'])){
		$errors['fullname'] = "Votre nom ne doit pas comporter de chiffres.";
	}

	if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])){
		$errors['username'] = "Votre pseudo n'est pas valide (alphanumérique uniquement).";
	} else {
		$req = $bdd->prepare('SELECT id FROM membres WHERE username = ?');
		$req->execute([$username]);
		$user = $req->fetch();
	}
	if ($user){
		$errors['username'] = "Ce pseudo est deja pris.";
	}

	if (empty($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
		$errors['mail'] = "Votre email n'est pas valide.";
	} else {
	$req = $bdd->prepare('SELECT id FROM membres WHERE mail = ?');
	$req->execute([$username]);
	$mail = $req->fetch();
}

	if ($user){
		$errors['mail'] = "Cet email est déjà utilisé pour un autre compte.";
	}

	if (empty($_POST['passwd']) || empty($_POST['passwd2']) || strlen($_POST['passwd']) < 6 ||
	!preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#', $passwd) || !preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#', $_POST['passwd2'])){
		$errors['passwd'] = "Vous devez entrer un mot de passe avec au moins un chiffre, une minuscule, une majuscule et un caractère spécial (#, @, &...).";
	}

	if (empty($_POST['passwd2']) || $_POST['passwd'] != $_POST['passwd2'] || strlen($_POST['passwd']) < 6){
		$errors['passwd'] = "Les mots de passe sont différents.";
	}

	if(empty($errors)){
		$req = $bdd->prepare("INSERT INTO membres SET username = ?, password = ?, mail = ?, confirmation_token = ?");

		$passwd = password_hash($_POST['passwd'], PASSWORD_BCRYPT);

		$token = str_random(60);

		// $req->execute([$_POST['username'], $passwd, $_POST['mail'], $token]);
		$req->execute([$username, $passwd, $email, $token]);

		$user_id = $bdd->lastInsertId();

		// mail($_POST['mail'], 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://localhost:8080/confirm.php?id=$user_id&token=$token");
		mail($email, 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://localhost:8080/confirm.php?id=$user_id&token=$token");

		$_SESSION['flash']['success'] = 'Un email de confirmation vous a été envoyé.';

		header('Location: login.php');
		exit();

		// $errors['success'] = "Votre compte a bien été crée !";
		// var_dump($_POST);
	}
	// debug($errors);
}
?>


<!---doctype html--->
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>SIGN UP</title>
  <link rel="stylesheet" href="css/style.css">
  <!-- <script src="script.js"></script> -->
</head>
<body>
 <div class="container">
            <div class="header"></div>
            <div class="menu"></div>
            <div class="content">
			<div class="title">CAMAGRU</div><br>
    		<div class="text">Sign up to see photos and videos from your friends.</div>

						<form action="" method="post">
								<div>
									<input type="text" id="fullname" name="fullname" maxlength="12" placeholder="<?php if(isset($_SESSION['auth']->fullname)) { echo $fullname;}  else {echo "Fullname";}?>">
								</div>
								<div>
									<!--  <label for="name">Nom :</label> -->
									<input type="text" id="username" name="username" maxlength="12"  placeholder="<?php if(isset($_SESSION['auth']->username)) { echo $username;}  else {echo "Username";}?>">
								</div>
								<div>
									<!--   <label for="mail">Mail :</label> -->
									<input type="email" id="mail" name="mail" placeholder="<?php if(isset($_SESSION['auth']->mail)) { echo $mail;} else {echo "Email";} ?>">
								</div>

								<div>
									<!-- <label for="pass">Password :</label> -->
									<input type="password" id="passwd" name="passwd" minlength="6"  placeholder="Password">
								</div>
								<div>
									<!-- <label for="pass">Password :</label> -->
									<input type="password" id="passwd2" name="passwd2" minlength="6"  placeholder="Repete password">
								</div>
								<div>
									<input type="submit" id="forminscription" name="forminscription" value="Submit">
								</div>
						</form>


				<?php if (!empty($errors)): ?>
				<?php foreach($errors as $error): ?>
						<li class="error">
							<?= $error; ?>
						</li>
				<?php endforeach; else : ?>
					<div  class="error"></div>
				<?php ; endif; ?>

				<div class="txt">By signing up, you agree to our Terms .
				Learn how we collect, use and share your data in our Data Policy and how we use cookies and similar technology in our Cookies Policy .</div>
				</div>
		<div class="article" class="text">Have an account ? <b>  <a href="login.php">&nbsp;Log in</a></b></div>
		<div class="footer">ABOUT US . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE</div>
</div>


</body>
</html>