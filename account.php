<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'camagru');
if(isset($_GET['id']) AND $_GET['id'] > 0)
{
	$getid= intval($_GET['id']);
	$requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
	$requser->execute(array($getid));
	$userinfo = $requser->fetch();
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Profile</title>
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
				      
				        Bonjour <?php echo $userinfo['pseudo']; ?>
				    </div>
				    <div>
						Mail : <?php echo $userinfo['mail']; ?>
				    </div>
		<?php 
		if (isset($_SESSION['id']) && $userinfo['id'] == $_SESSION['id']){
			?>
		<a href="#"> Editer non profil</a>
		<?
		}
		?>
		</form>
		<br>
		<br>
		<?php
		if (isset($erreur))
		{
			echo $erreur;
		}
		?>
		<!-- <div class="txt"><a href="forgot_passwd.php">Forgot password?</a></div> -->
</div>
<!-- <div class="article" class="text">Don't have an account?<b>  <a href="signup.php">&nbsp;Sign up</a></b></div> -->

            <div class="footer">ABOUT US . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE</div>
        </div>
  
</body>
</html>

<?php
}
?>
