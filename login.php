<?php
session_start();
include_once("navigation.php");
include_once("user_functions.php");
include_once("db.php");


if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['passwd']))
{
	$req = $bdd->prepare('SELECT * FROM membres WHERE (username = :username OR mail = :username) AND confirmed_at IS NOT NULL');
	$req->execute(['username' => $_POST['username']]);
	$user = $req->fetch();
	if(password_verify($_POST['passwd'], $user->password)){
		$_SESSION['auth'] = $user;
		$_SESSION['flash']['success'] = 'Vous etes maintenant connecte au site';
		header('Location: account.php');
		exit();
	}
	else{
		$_SESSION['flash']['warning'] = 'Identifiant ou mdp incorrect';
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
            <div class="header">CAMAGRU</div>
            <div class="menu"></div>
            <div class="content">
			<div class="title">CAMAGRU</div><br>

    		<form action="" method="post">
				    <div>
				       <!--  <label for="name">Nom :</label> -->
				        <input type="text" id="username" name="username" placeholder="Username">
				    </div>
				    <div>
				        <input type="password" id="passwd" name="passwd" minlength="6" required placeholder="Password">
				    </div>
					<div>
				 	  <input type="submit"value="Log In">
					</div>
		</form>

	
		<div class="txt"><a href="forgot_passwd.php">Forgot password?</a></div>
</div>
<div class="article" class="text">Don't have an account?<b>  <a href="signup.php">&nbsp;Sign up</a></b></div>

            <div class="footer">ABOUT US . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE</div>
        </div>
  
</body>
</html>
