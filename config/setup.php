<?php
	require 'config/database.php';

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


	// $pdo = null; // Deconnexion au serveur de BDD


    // Creation de la table users
    try {
        $sql = "CREATE TABLE IF NOT EXISTS `membres`
        (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255),
            mail VARCHAR(255),
            password TEXT,
            confirmation_token VARCHAR(60) NULL,
			confirmed_at DATETIME NULL,
			reset_token VARCHAR(60) NULL,
			reset_at DATETIME NULL,
			remember_token VARCHAR(250),
			mail_active TINYINT(1)
        );";
        $bdd->prepare($sql)->execute();
	} catch(PDOException $ex) { exit($ex); };

    try {
        $sql = "CREATE TABLE IF NOT EXISTS `photos`
        (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            photo LONGTEXT,
            author_id INT(11),
            nb_like BIGINT(20),
            create_date DATETIME DEFAULT NOW(),
        );";
        $bdd->prepare($sql)->execute();
	} catch(PDOException $ex) { exit($ex); };

	try {
        $sql = "CREATE TABLE IF NOT EXISTS `comments`
        (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            comment VARCHAR(255),
            date DATETIME DEFAULT NOW(),
            uid INT(11),
            photo_id INT(11)
        );";
        $bdd->prepare($sql)->execute();
    } catch(PDOException $ex) { exit($ex); };
?>