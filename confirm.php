<?php
session_start();

$user_id = $_GET['id'];
$token = $_GET['token'];

require 'config/setup.php';

$req = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
$req->execute([$user_id]);
$user = $req->fetch();

if($user && $user->confirmation_token == $token){

	$_req = $bdd->prepare('UPDATE membres SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?')->execute([$user_id]);

	$_SESSION['flash']['success'] = "Votre compte a bien été validé.";

	$_SESSION['auth'] = $user;

	header('Location: account.php');

} else {
	$_SESSION['flash']['warning'] = "Ce token n'est plus valide";
	header('Location: login.php');
}

?>
