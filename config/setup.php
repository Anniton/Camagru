<?php
	require 'config/database.php';
	// try
	// {
	// 	$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', $DB_USER, $DB_PASSWORD);
	// 	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// } catch(PDOException $ex) { exit($ex); };

  // Connexion a la BDD
try {
	$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$bdd->setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION);
	$bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
} catch(PDOException $ex) { exit($ex); };

    // Creation de la BDD
    try {
        $sql = "CREATE DATABASE IF NOT EXISTS $db;";
        $bdd->prepare($sql)->execute();
	} catch(PDOException $ex) { exit($ex); };

	$pdo = null; // Deconnexion au serveur de BDD


    // Creation de la table users
    try {
        $sql = "CREATE TABLE IF NOT EXISTS `membres`
        (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(20),
            mail VARCHAR(64),
            password VARCHAR(128),
            username VARCHAR(20),
            profile_pic VARCHAR(42)
        );";
        $bdd->prepare($sql)->execute();
	} catch(PDOException $ex) { exit($ex); };

    try {
        $sql = "CREATE TABLE IF NOT EXISTS `photos`
        (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            create_date DATETIME DEFAULT NOW(),
            photo VARCHAR(20),
            nb_like BIGINT(20),
            author_id INT(11)
        );";
        $bdd->prepare($sql)->execute();
	} catch(PDOException $ex) { exit($ex); };

	try {
        $sql = "CREATE TABLE IF NOT EXISTS `comments`
        (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            date DATETIME DEFAULT NOW(),
            comment VARCHAR(255),
            uid BIGINT(11),
            photo_id INT(11)
        );";
        $bdd->prepare($sql)->execute();
    } catch(PDOException $ex) { exit($ex); };
?>