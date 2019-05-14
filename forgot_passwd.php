<?php
session_start();
include_once("navigation.php");
include_once("user_functions.php");
include_once("db.php");


if(!empty($_POST) && !empty($_POST['mail']))
{

	$email = htmlspecialchars($_POST['mail']);
	$req = $bdd->prepare('SELECT * FROM membres WHERE mail = ? AND confirmed_at IS NOT NULL');
	// $req->execute([$_POST['mail']]);
	$req->execute([$email]);
	$user = $req->fetch();

	if($user){
		$reset_token = str_random(60);

		$bdd->prepare('UPDATE membres SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user->id]);
	
		$_SESSION['flash']['success'] = 'Les instruction du rappel de mot de passe vous ont ete envoye par email';
		// mail($_POST['mail'], 'Reinitialisation du mot de passe', "Afin de reinitialiser votre mot de passe cliquer sur ce lien\n\nhttp://localhost:8080/reset.php?id={$user->id}&token=$reset_token");
		mail($email, 'Reinitialisation du mot de passe', "Afin de reinitialiser votre mot de passe cliquer sur ce lien\n\nhttp://localhost:8080/reset.php?id={$user->id}&token=$reset_token");
		
		header('Location: login.php');
		exit();
	}
	else{
		$_SESSION['flash']['warning'] = 'aucun compte ne correspond a cette adresse';
	}
}

?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="style.css">	
  <script src="script.js"></script>
</head>


<body>
 <div class="container">
            <div class="header">CAMAGRU</div>
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
		<br>
		<br>
		<div class="txt"><a href ="signup.php">Create New Account</a></div>
</div>
<div class="article" class="text"><b><a href="login.php">Back To Login</a></b></div>

            <div class="footer">ABOUT US . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE</div>
        </div>
  
</body>
</html>
