<?php
session_start();

$user_id = $_GET['id'];
$token = $_GET['token'];

require 'db.php';
$req = $bdd->prepare('SELECT confirmation_token FROM membres WHERE id = ?');
$req->execute([$user_id]);
$user = $req->fetch();

if($user && $user->confirmation_token == $token){
 
    $_req = $bdd->prepare('UPDATE membres SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?')->execute([$user_id]);
    $_SESSION['auth'] = $user;
    
    header('Location: account.php');
    die('ok');
} else {
    die('not ok');
}

?>