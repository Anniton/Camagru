<?php
session_start();

require("navigation.php");

//  $bdd = new PDO('mysql:host=127.0.0.1:3306;dbname=espace_membre', 'root', 'camagru');
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'camagru');
print_r($_POST);
if (isset($_POST['forminscription']))
{
	$fullname = htmlspecialchars($_POST['fullname']);
	$username = htmlspecialchars($_POST['username']);
	$mail = htmlspecialchars($_POST['mail']);
	$mail2 = htmlspecialchars($_POST['mail2']);
	$passwd = sha1($_POST['passwd']);
	$passwd2 = sha1($_POST['passwd2']);

	if(!empty($_POST['fullname']) AND !empty($_POST['username']) AND !empty($_POST['passwd']) AND !empty($_POST['passwd2']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']))
	{
		$usernamelength = strlen($username);
 			if ($usernamelength <= 12)
 			{
 				if ($mail == $mail2){
					if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
 							$reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ? OR pseudo = ?");
							$reqmail->execute(array($mail, $username));
							$mailexist = $reqmail->rowCount();
 							 if($mailexist == 0) {
									if ($passwd == $passwd2)
									{
										$insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, mail, motdepasse) VALUES(?, ?, ?)");
							
										$insertmbr->execute(array($username, $mail, $passwd));
										$erreur = "Votre compte a bien été crée !";
									}
									else
									{
										$erreur = "The passwords are differents.";
									} 
								}
							else
 							{
 								$erreur = "Email or Username already used.";
							 }
							} 
 							 else 
							{
 								$erreur = "Email is not valid.";
 							}
 				} else {
 					$erreur = "Email are differents.";
 				}
 			} else {
 				$erreur = "The username must be < 255 characters";
 			}
	} else {
		$erreur = "Tous les champs doivent etre remplis";
	}
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
				      <!--   <label for="mail">Mail :</label> -->
				        <input type="email" id="mail2" name="mail2" placeholder="Repete Email" value="<?php if(isset($mail)) { echo $mail;} ?>">
				    </div>
				    <div>
							<!-- <label for="pass">Password :</label> -->
				        <input type="password" id="passwd" name="passwd"
		           minlength="6"  placeholder="Password">
				    </div>
						<div>
							<!-- <label for="pass">Password :</label> -->
				        <input type="password" id="passwd2" name="passwd2"
		           minlength="6"  placeholder="Repete password">
				    </div>
					<div>
				 	  <input type="submit" id="forminscription" name="forminscription" value="Submit">
					</div>
		</form>	
		<?php
		if (isset($erreur))
		{
			echo $erreur;
		}
		?>


		<div class="txt">By signing up, you agree to our Terms . Learn how we collect, use and share your data in our Data Policy and how we use cookies and similar technology in our Cookies Policy .</div>
</div>
<div class="article" class="text">Have an account ? <b>  <a href="login.php">&nbsp;Log in</a></b></div>

            <div class="footer">ABOUT US . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE</div>
        </div>
  
</body>
</html>