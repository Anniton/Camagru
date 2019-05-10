<?php
session_start();
include_once('navigation.php');
require_once('user_functions.php');
include_once('db.php');

logged_only();

if(!empty($_POST)){
	if(!empty($_POST['passwd']) || $_POST['passwd'] != $_POST['passwd_confirm']){
		$_SESSiON['flash']['warning'] = "Passwords are differents";
	}
	else{
		$user_id = $_SSSION['auth']->id;
		$password = password_hash($_O+POST['password'], PASSWORD_BCRYPT);

		$bdd->prepare('UPDATE membres SET password = ?')->execute([$password]);
		$_SESSION['flash']['success'] = "Password update";
	}
}
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
						<div>Bonjour <?= $_SESSION['auth']->username; ?></div>

						<form action="" method="post">
						<div class="form-group">
										<input class="form-control" type="text" name="username" placeholder="<?= $_SESSION['auth']->username; ?>">
								</div>
								<div class="form-group">
										<input class="form-control" type="text" name="username_confirm" placeholder="Confirm username">
								</div>
								<div> <input type="submit" id="cg_username" name="cg_username" value="Submit"></div>
								<div class="form-group">
										<input class="form-control" type="password" name="passwd" placeholder="New password">
								</div>
								<div class="form-group">
										<input class="form-control" type="password" name="passwd_confirm" placeholder="Confirm password">
								</div>
								<div> <input type="submit" id="cg_passwd" name="cg_passwd" value="Submit"></div>
						</form>


	
		<div class="txt"><a href="forgot_passwd.php"></a></div>
</div>
<!-- <div class="article" class="text">Don't have an account?<b>  <a href="signup.php">&nbsp;Sign up</a></b></div> -->

            <div class="footer">ABOUT US . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE</div>
        </div>
  
</body>
</html>
