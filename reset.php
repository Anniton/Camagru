<?php
session_start();
include_once("navigation.php");
include_once("user_functions.php");
require 'config/setup.php';

$email = htmlspecialchars($_POST['mail']);
$user_id = htmlspecialchars(urldecode($_GET['id']));
$token = htmlspecialchars(urldecode($_GET['token']));
$user_id = htmlspecialchars(urldecode($_GET['id']));
$token = htmlspecialchars(urldecode($_GET['token']));

if(isset($_GET['id']) && isset($_GET['token']))
{
    $req = $bdd->prepare('SELECT * FROM membres WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 40 MINUTE)');
    // $req->execute([$_GET['id'], $_GET['token']]);
    $req->execute([$user_id, $token]);
	$user = $req->fetch();
	if($user){
        if(!empty($_POST)){
            if(!empty($_POST['passwd']) && $_POST['passwd'] == $_POST['passwd_confirm'] && preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#',$_POST['passwd'])){
                $password = password_hash($_POST['passwd'], PASSWORD_BCRYPT);
                $bdd->prepare('UPDATE membres SET password = ?, reset_at = NULL, reset_token = NULL')->execute([$password]);
                session_start();
                $_SESSION['flash']['success'] = "Votre mot de passe a bien été modifié.";
                $_SESSION['auth'] = $user;
                header('Location: account.php');
                exit();
			}
			if (!preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#',$_POST['passwd'])){
				$errors['passwd'] = "Vous devez entrer un mot de passe avec au moins un chiffre, une minuscule, une majuscule et un caractère spécial (#, @, &...).";
			}
			if (empty($_POST['passwd2']) || $_POST['passwd'] != $_POST['passwd2'] || strlen($_POST['passwd']) < 6){
				$errors['passwd'] = "Les mots de passe sont différents.";
			}
        }
    }
    else{
        $_SESSION['flash']['error'] = "Ce token n'est pas valide";
        header('Location: login.php');
        exit;
    }
}
else{
    header('Location: login.php');
    exit();
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
    		<div class="text">Please enter a new password.</div>

    		<form action="" method="post">
                     <div>
				        <input type="password" id="passwd" name="passwd" minlength="6"  placeholder="Password">
				    </div>
                    <div>
				        <input type="password" id="passwd_confirm" name="passwd_confirm" minlength="6"  placeholder="Confirm password">
				    </div>
                    <div>
				 	  <input type="submit" id="forminscription" name="forminscription" value="Reset password">
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
