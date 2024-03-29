<?php
session_start();
include_once('navigation.php');
require_once('user_functions.php');
require 'config/setup.php';


logged_only();

if ($_SESSION['auth']){
	$errors_mdp = array();
	$errors_mail = array();
	$errors_name = array();

	if(!empty($_POST)){
		$newusername = htmlspecialchars($_POST['new_username']);
		if (empty($_POST['new_username']) || !preg_match('/^[a-zA-Z]+$/',$_POST['new_username'])){
			$errors_name['name']= "Votre pseudo n'est pas valide (alphanumérique uniquement).";
		}
		else {
			$req = $bdd->prepare("SELECT username FROM membres WHERE username=?");
			$req->execute([$newusername]);
			$is_ex_uname = $req->fetchAll();
			if (empty($is_ex_uname)) {
				$user_id = $_SESSION['auth']->id;

				$bdd->prepare('UPDATE membres SET username = ? WHERE id = ?')->execute([$newusername, $user_id]);
				$errors_name['name'] = "Le nom d'utilisateur a bien été modifié.";
			}
			else {
				$errors_name['name'] = "Votre pseudo est déjà utilisé.";
			}
		}
	}

	if(!empty($_POST)){

		if(empty($_POST['passwd']) || ($_POST['passwd'] != $_POST['passwd2'])){
			// $_SESSION['flash']['warning'] = "Passwords are differents";
			$errors_mdp['passwd_cg'] = "Les mots de passe sont différents.";
		}
		elseif (empty($_POST['passwd']) || empty($_POST['passwd2']) || strlen($_POST['passwd']) < 6 ||
				(!preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#', $_POST['passwd'])) ||
				(!preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#', $_POST['passwd2']))){
			$errors_mdp['passwd_cg'] = "Vous devez entrer au moins un chiffre, une minuscule, une majuscule et un caractère spécial(#, @, &...).";
		}
		else {
			$user_id = $_SESSION['auth']->id;
			$password = password_hash($_POST['passwd'], PASSWORD_BCRYPT);
			$bdd->prepare('UPDATE membres SET password = ? WHERE id = ?')->execute([$password, $user_id]);
			$errors_mdp['passwd_cg'] = "Le mot de passe a bien été modifié.";
		}
	}

	if(!empty($_POST)){
		if (empty($_POST['mail']) || ($_POST['mail'] != $_POST['mail_confirm'])){
			$errors_mail['mail_cg'] = "Les email sont différents.";
		}
		else {
			$user_id = $_SESSION['auth']->id;
			$mail = htmlspecialchars($_POST['mail']);
			$bdd->prepare('UPDATE membres SET mail = ? WHERE id = ?')->execute([$mail, $user_id]);
			// $_SESSION['flash']['success'] = "Mail update";
			$errors_mail['mail_cg'] = "L'email a bien été modifié.";
		}
	}

	if(!empty($_POST)){
		$user_id = $_SESSION['auth']->id;
		if (!empty($_POST['validated_mail'])){
			$mail_active = $_POST['validated_mail'];
			$mail_unactive = $_POST['unvalidated_mail'];
			if ($_POST['validated_mail'] === '1'){
				$bdd->prepare('UPDATE membres SET mail_active = ? WHERE id = ?')->execute([$mail_active, $user_id]);
				$errors_sendmail['mail_cg'] = "Vous avez activé les emails";
			}
			else if ($_POST['validated_mail'] === '2'){
				$bdd->prepare('UPDATE membres SET mail_active = ? WHERE id = ?')->execute([$mail_unactive, $user_id]);
				$errors_sendmail['mail_cg'] = "Vous avez desactivé les emails";
			}
			header("Location: account.php");
		}
	}

	if(!empty($_POST)){
	$res1 = $bdd->prepare('SELECT mail_active FROM membres WHERE id = ?');
	$res1->execute([$_SESSION['auth']->id]);
	$res11 = (int)$res1->fetchAll()[0]->mail_active;
	}
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>ACCOUNT</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/script.js"></script>
</head>
<body>
 <div class="container">
			<!-- <div class="header">CAMAGRU</div> -->
			<div class="menu"></div>
			<div class="content">
			<div style="margin-top:20px; font-weight:bold">Bonjour <?= $_SESSION['auth']->username; ?>,</div>
			<br/>


			<form id="cg_username" action="" method="post">
				<br/>
				<div> CHANGE USERNAME </div>
				<div>
				<input  type="text" name="new_username" placeholder="<?= $_SESSION['auth']->username; ?>">
				</div>
				<div> <input type="submit" name="cg_username" value="Change username"></div>
			</form>
			<?php if (!empty($errors_name) && !empty($_POST['new_username'])): ?>
				<?php foreach($errors_name as $error): ?>
						<div class="error">
							<?= $error; ?>
							<?php endforeach; ?>
						</div>
				<?php elseif (empty($_POST['new_username'])) : ?>
				<div style="display=none"; class="error"></div>
				<?php ; ?>
			<?php endif; ?>

			<form id="cg_mdp" action="" method="post">
					<br/>
					<div> CHANGE PASSWORD</div>
					<div>
					<input type="password" name="passwd" minlength="6"  placeholder="New password">
					</div>
					<div>
					<input type="password" name="passwd2" minlength="6"  placeholder="Confirm new password">
					</div>
					<div> <input type="submit" name="cg_mdp" value="Change my password"></div>
			</form>
			<?php if (!empty($errors_mdp) && !empty($_POST['passwd']) && !empty($_POST['passwd2'])): ?>
				<?php foreach($errors_mdp as $error): ?>
						<div class="error">
							<?= $error; ?>
							<?php endforeach; ?>
						</div>
				<?php elseif (empty($_POST['passwd']) && empty($_POST['passwd2'])) : ?>
				<div style="display=none"; class="error"></div>
				<?php ; ?>
			<?php endif; ?>

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
			</form>
			<?php if (!empty($errors_mail) && !empty($_POST['mail']) && !empty($_POST['mail_confirm'])): ?>
				<?php foreach($errors_mail as $error): ?>
						<div class="error">
							<?= $error; ?>
							<?php endforeach; ?>
						</div>
			<?php elseif (empty($_POST['mail']) || empty($_POST['mail_confirm'])): ?>
					<div style="display=none"; class="error"></div>
				<?php ; ?>
			<?php endif; ?>

			<form id="active_mail"  action="account.php" method="post">
			 <?php if ($res11 == 1) { ?>
					<input type="radio" name="validated_mail" value="1" checked="checked"/>Enable email
					<input type="radio" name="validated_mail" value="2"/>Disable email
			 <?php  } else { ?>
					<input type="radio" name="validated_mail" value="1"/>Enable email
					<input type="radio" name="validated_mail" value="2" checked="checked"/>Disable email
			<?php  }  ?>
			<div><input type="submit" value="Submit"></div>
			</form>
			<?php if (!empty($errors_sendmail)): ?>
				<?php foreach($errors_sendmail as $error): ?>
						<div class="error">
							<?= $error; ?>
							<?php endforeach; ?>
						</div>
			<?php endif; ?>

		<div class="txt"><a href="forgot_passwd.php"></a></div>
</div>

			<div class="footer">ABOUT AQUAN . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE</div>
		</div>

</body>
<script async src="js/script.js"></script>
</html>
<?php
}
else {
	header("Location: login.php");
}
?>
