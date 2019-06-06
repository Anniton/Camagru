<?php
session_start();
include_once("navigation.php");
include_once("user_functions.php");
require 'config/setup.php';


if(!empty($_POST) && !empty($_POST['mail']))
{
	$errors = array();
	$email = htmlspecialchars($_POST['mail']);
	$req = $bdd->prepare('SELECT * FROM membres WHERE mail = ? AND confirmed_at IS NOT NULL');
	// $req->execute([$_POST['mail']]);
	$req->execute([$email]);
	$user = $req->fetch();

	if($user){
		$reset_token = str_random(60);

		$bdd->prepare('UPDATE membres SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user->id]);

		$_SESSION['flash']['success'] = 'Les instructions du rappel de mot de passe vous ont été envoyé par email.';
		// mail($_POST['mail'], 'Reinitialisation du mot de passe', "Afin de reinitialiser votre mot de passe cliquer sur ce lien\n\nhttp://localhost:8080/reset.php?id={$user->id}&token=$reset_token");
		mail($email, 'Reinitialisation du mot de passe', "Afin de reinitialiser votre mot de passe cliquer sur ce lien\n\nhttp://localhost:8080/reset.php?id={$user->id}&token=$reset_token");

		header('Location: login.php');
		exit();
	}
	else{
		// $_SESSION['flash']['warning'] = 'Aucun compte ne correspond à cette adresse';
		$errors['mail'] = 'Aucun compte ne correspond à cette adresse.';
	}
}

?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/script.js"></script>
</head>


<body>
 <div class="container">
            <!-- <div class="header">CAMAGRU</div> -->
            <div class="menu"></div>
            <div class="content">
			<div class="title">Trouble Logging In?</div><br>
    		<div class="text">Enter your email and we'll send you a link to get back into your account.</div>

    		<form action="" method="post">
				    <div>
				        <input type="email" id="mail" name="mail" placeholder="Email">
				    </div>
					<div>
				 	  <input type="submit" value="Send Login Link">
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
		<br>
		<br>
		<div class="txt"><a href ="index.php">Create New Account</a></div>
</div>
<div class="article" class="text"><b><a href="login.php">Back To Login</a></b></div>

            <div class="footer">ABOUT AQUAN . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE</div>
        </div>

</body>
</html>
