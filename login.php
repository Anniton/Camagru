<?php
session_start();
include_once("navigation.php");
include_once("user_functions.php");
require 'config/setup.php';

if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['passwd']))
{
	$username = htmlspecialchars($_POST['username']);
	$errors = array();

	$req = $bdd->prepare('SELECT * FROM membres WHERE (username = :username OR mail = :username) AND confirmed_at IS NOT NULL');
	$req->execute(['username' => $username]);
	$user = $req->fetch();
	if (password_verify($_POST['passwd'], $user->password)){
		$_SESSION['auth'] = $user;
		// $_SESSION['flash']['success'] = 'Vous etes maintenant connecte au site';
		// if ($_POST['remember']){
		// 	$remember_token = str_random(250);
		// 	$bdd->prepare('UPDATE membres SET remember_token = ? WHERE id = ?')->execute([$remember_token, $user->id]);
		// 	// setcookie('remember', $user->id . '==' . $remember_token . sha1($user->id . 'ratonlaveurs'), time() + 60 * 60 * 24 * 7);
		// }
		header('Location: account.php');
		exit();
	}
	else{
		// $_SESSION['flash']['warning'] = ' Identifiant ou mdp incorrect';
		$errors['faux'] = "Identifiant ou mot de passe incorrect.";
		// header('Location: login.php');
		// exit();
	}
}
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>login</title>
  <link rel="stylesheet" href="style.css">
  <script src="script.js"></script>
</head>


<body>
 <div class="container">
            <!-- <div class="header">CAMAGRU</div> -->
            <div class="menu"></div>
            <div class="content">
			<div class="title">CAMAGRU</div><br>

    		<form action="" method="post">
				    <div>
				        <input type="text" id="username" name="username" placeholder="Username">
				    </div>
				    <div>
				        <input type="password" id="passwd" name="passwd" minlength="6" required placeholder="Password">
				    </div>

					<div>
				 	  <input type="submit"value="Log In">

					</div>
		</form>
		<?php if (!empty($errors)): ?>
				<?php foreach($errors as $error): ?>
						<div class="error">
							<?= $error; ?>
							<?php endforeach; ?>
						</div>
				<?php else : ?>
					<div  class="error"></div>
				<?php ; ?>

		<?php endif; ?>

		<div class="txt"><a href="forgot_passwd.php">Forgot password?</a></div>
</div>
<div class="article" class="text">Don't have an account?<b>  <a href="index.php">&nbsp;Sign up</a></b></div>

            <div class="footer">ABOUT AQUAN . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE</div>
        </div>

</body>
</html>
