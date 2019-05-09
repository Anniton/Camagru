<?php
session_start();
require("navigation.php");
include("user_functions.php");
require_once 'db.php';

if(!empty($_POST)){

	$errors = array();

	// if (empty($_POST['fullname']) || !preg_match('/^[a-zA-Z]+$/', $_POST['fullname'])){
	// 	$errors['fullname'] = "Votre nom ne doit pas comporter de chiffres.";
	// }

	if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])){
		$errors['username'] = "Votre pseudo n'est pas valide (alphanumerique).";
	} else {
		$req = $bdd->prepare('SELECT id FROM membres WHERE username = ?');
		$req->execute([$_POST['username']]);
		$user = $req->fetch();
	}
	if ($user){
		$errors['username'] = "Ce pseudo est deja pris.";
	}

	if (empty($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
		$errors['mail'] = "Votre email n'est pas valide.";
	}  else {
	$req = $bdd->prepare('SELECT id FROM membres WHERE mail = ?');
	$req->execute([$_POST['username']]);
	$mail = $req->fetch();}

	if ($user){
			$errors['mail'] = "Ce mail est deja utilise pour un autre compte.";
	}

	if (empty($_POST['passwd']) || $_POST['passwd'] != $_POST['passwd2']){
		$errors['passwd'] = "Vous devez entrer un mot de passe valide.";
	}

	if(empty($errors)){
		$req = $bdd->prepare("INSERT INTO membres SET username = ?, password = ?, mail = ?");
		$passwd = password_hash($_POST['passwd'], PASSWORD_BCRYPT);
		$req->execute([$_POST['username'], $passwd, $_POST['mail']]);
		$errors['success'] = "Votre compte a bien été crée !";
	}
	// debug($errors);
}
?> 


<!---doctype html--->
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Sign Up</title>
  <link rel="stylesheet" href="style.css">	
  <!-- <script src="script.js"></script> -->
</head>
<body>
 <div class="container">
            <div class="header">CAMAGRU</div>
            <div class="menu"></div>
            <div class="content">
			<div class="title">CAMAGRU</div><br>
    		<div class="text">Sign up to see photos and videos from your friends.</div>
	
    		<form action="signup.php" method="post">
    			<div>
				    	 <input type="text" id="fullname" name="fullname" maxlength="12" placeholder="Full Name" value="<?php if(isset($fullname)) { echo $fullname;} ?>">
				 </div>
				    <div>
				       <!--  <label for="name">Nom :</label> -->
				        <input type="text" id="username" name="username" maxlength="12"  placeholder="Username" value="<?php if(isset($username)) { echo $username;} ?>">
				    </div>
				    <div>
				      <!--   <label for="mail">Mail :</label> -->
				        <input type="email" id="mail" name="mail" placeholder="Email" value="<?php if(isset($mail)) { echo $mail;} ?>">
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
		<!-- <div class="error"> -->
				<?php if (!empty($errors)): ?>
						<!-- <div></div> -->
						<?php foreach($errors as $error): ?>
							<?= $error; ?>
						<?php endforeach; ?>
<!-- 
				</div> -->
				<?php endif; ?>		
			<!-- </div> -->
			

<div class="txt">By signing up, you agree to our Terms . Learn how we collect, use and share your data in our Data Policy and how we use cookies and similar technology in our Cookies Policy .</div>
</div>
<div class="article" class="text">Have an account ? <b>  <a href="login.php">&nbsp;Log in</a></b></div>
<div class="footer">ABOUT US . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE</div>
        </div>
</body>
</html>