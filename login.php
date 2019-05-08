<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'camagru');
print_r($_POST);
if(isset($_POST['formconnexion']))
$usernameconnect = htmlspecialchars($_POST['usernameconnect']);
$passwdconnect = sha1($_POST['passwdconnect']);
if(!empty($usernameconnect) && !empty($passwdconnect))
{
	$requser = $bdd->prepare("SELECT * FROM membres WHERE pseudo = ? AND motdepasse = ?");
	$requser->execute(array($usernameconnect, $passwdconnect));
	$userexist = $requser->rowCount();
	if($userexist == 1)
	{
		$userinfo = $requser->fetch();
		$_SESSION['id'] = $userinfo['id'];
		$_SESSION['pseudo'] = $userinfo['pseudo'];
		$_SESSION['mail'] = $userinfo['mail'];
		header("Location: profil.php?id=". $_SESSION['id']);

	}
	else
	{
		$erreur = "Wrong user or wrong password.";
	}
}
else {
	echo "Tous les champs doivent être completés";
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

    		<form action="login.php" method="post">
				    <div>
				       <!--  <label for="name">Nom :</label> -->
				        <input type="text" id="usernameconnect" name="usernameconnect" placeholder="Username">
				    </div>
				    <div>
				        <input type="password" id="passwdconnect" name="passwdconnect"
		           minlength="6" required placeholder="Password">
				    </div>
					<div>
				 	  <input type="submit" name="formconnexion" value="Log In">
					</div>
		</form>
		<br>
		<br>
		<?php
		if (isset($erreur))
		{
			echo $erreur;
		}
		?>
		<div class="txt"><a href="forgot_passwd.php">Forgot password?</a></div>
</div>
<div class="article" class="text">Don't have an account?<b>  <a href="signup.php">&nbsp;Sign up</a></b></div>

            <div class="footer">ABOUT US . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE</div>
        </div>
  
</body>
</html>
