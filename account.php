<?php
session_start();
include_once('navigation.php');
require_once('user_functions.php');
include_once('db.php');


logged_only();

if ($_SESSION['auth']){
	if(!empty($_POST)){
		if(!empty($_POST['new_username'])){
			$user_id = $_SESSION['auth']->id;
			var_dump($_SESSION);
			$newusername = htmlspecialchars($_POST['new_username']);
			$bdd->prepare('UPDATE membres SET username = ? WHERE id = ?')->execute([$newusername, $user_id]);
			$_SESSION['flash']['success'] = "Username update";
		}
		elseif ($_POST['validated_mail'])
		{
			var_dump("OUIIIIIII!!!");
		}
		else {
			header('Location: account.php');
		}
	}

	// if(!empty($_POST)){
	// 	if(empty($_POST['passwd']) || ($_POST['passwd'] != $_POST['passwd_confirm'])){
	// 		$_SESSION['flash']['warning'] = "Passwords are differents";
	// 	}
	// 	else {
	// 		$user_id = $_SESSION['auth']->id;
	// 		$password = password_hash($_POST['passwd'], PASSWORD_BCRYPT);
	// 		$bdd->prepare('UPDATE membres SET password = ? WHERE id = ?')->execute([$password, $user_id]);
	// 		$_SESSION['flash']['success'] = "Password update";
	// 	}
	// }

	// if(!empty($_POST)){
	// 	if(empty($_POST['mail']) || ($_POST['mail'] != $_POST['mail_confirm'])){
	// 		echo "Mail are differents";
	// 	}
	// 	else {
	// 		$user_id = $_SESSION['auth']->id;
	// 		$mail = htmlspecialchars($_POST['mail']);
	// 		$bdd->prepare('UPDATE membres SET mail = ? WHERE id = ?')->execute([$mail, $user_id]);
	// 		$_SESSION['flash']['success'] = "Mail update";
	// 	}
	// }

	if(!empty($_POST)){
		$user_id = $_SESSION['auth']->id;
		if(!empty($_POST['validated_mail'])){
		$mail_active = $_POST['validated_mail'];
		$mail_unactive = $_POST['unvalidated_mail'];
		var_dump($mail_active);
		if(!empty($_POST['validated_mail'])){
			$bdd->prepare('UPDATE membres SET mail_active = ? WHERE id = ?')->execute([$mail_active, $user_id]);
			var_dump($mail_active);
		}
		else if(!empty($_POST['unvalidated_mail'])){
			$bdd->prepare('UPDATE membres SET mail_active = ? WHERE id = ?')->execute([$mail_unactive, $user_id]);
			var_dump($mail_unactive);
		}
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
			<div>Bonjour <?= $_SESSION['auth']->username; ?>,</div>
				<br/>


			<form id="cg_username" action="" method="post">
				<br/>
				<div> CHANGE USERNAME </div>
				<div>
				<input  type="text" name="new_username" placeholder="<?= $_SESSION['auth']->username; ?>">
				</div>
				<div> <input type="submit" name="cg_username" value="Change username"></div>
			</form>

<!--
			<form id="cg_mdp" action="" method="post">
					<br/>
					<div> CHANGE PASSWORD</div>
					<div>
					<input type="password" name="passwd" placeholder="New password">
					</div>
					<div>
					<input type="password" name="passwd_confirm" placeholder="Confirm new password">
					</div>
					<div> <input type="submit" name="cg_mdp" value="Change my password"></div>
			</form>


			<form id="cg_mail"  action="" method="post">
					<br/>
					<div> CHANGE MAIL</div>
					<div class="form-group">
					<input class="form-control" type="email" name="mail" placeholder="<?= $_SESSION['auth']->mail; ?>">
					</div>
					<div class="form-group">
					<input class="form-control" type="email" name="mail_confirm" placeholder="<?= $_SESSION['auth']->mail; ?>">
					</div>
					<div> <input name="cg_mail" type="submit" value="Change my mail"></div>
			</form> -->

			<form id="active_mail"  action="account.php" method="post">
					<input type="radio" name="validated_mail" value="1"/>Enable email
					<input  type="radio" name="unvalidated_mail" value="0"/>Disable email
					<div><input type="submit" value="Submit"></div>
			<?php
			var_dump($_POST['validated_mail']);
			?>
			</form>


		<div class="txt"><a href="forgot_passwd.php"></a></div>
</div>
<!-- <div class="article" class="text">Don't have an account?<b>  <a href="index.php">&nbsp;Sign up</a></b></div> -->

			<div class="footer">ABOUT US . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE</div>
		</div>

</body>
<script async src="script.js"></script>
</html>
<?php
}
else {
	header("Location: login.php");
}
?>
