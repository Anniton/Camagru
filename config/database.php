<?php
session_start();
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'camagru');
	$DB_DSN = mysql:host=localhost;dbname=test;
	$DB_USER = $username;
	$DB_FULLNAME = $name;
	$DB_PASSWORD = $passwd;
	$DB_EMAIL = $mail;
	$base->exec("CREATE DATABASE camagru DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
?>