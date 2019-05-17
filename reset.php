<?php
session_start();
include_once("navigation.php");
include_once("user_functions.php");
include_once("db.php");

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
            if(!empty($_POST['passwd']) && $_POST['passwd'] == $_POST['passwd_confirm']){
                $password = password_hash($_POST['passwd'], PASSWORD_BCRYPT);
                $bdd->prepare('UPDATE membres SET password = ?, reset_at = NULL, reset_token = NULL')->execute([$password]);
                session_start();
                $_SESSION['flash']['success'] = "Votre mot de passe a bien ete modifie";
                $_SESSION['auth'] = $user;
                header('Location: account.php');
                exit();
                
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
							<!-- <label for="pass">Password :</label> -->
				        <input type="password" id="passwd" name="passwd" minlength="6"  placeholder="Password">
				    </div>
                    <div>
							<!-- <label for="pass">Password :</label> -->
				        <input type="password" id="passwd_confirm" name="passwd_confirm" minlength="6"  placeholder="Confirm password">
				    </div>
                    <div>
				 	  <input type="submit" id="forminscription" name="forminscription" value="Reset password">
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